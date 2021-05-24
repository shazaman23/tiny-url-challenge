<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

// Models
use App\Models\TinyUrl;

class TinyUrlController extends Controller
{
    /**
     * Displays the top 100 URLs
     * @return Response
     */
    public function index(Request $request) {
        // Allow users to pick limit. Default to 100 entries
        $limit = 100;
        if ($request->query('limit') !== null) {
            $limit = (int)$request->query('limit');
        }
        $tiny_urls = json_decode($this->list($request)->content());
        return view('home', [
            'tiny_urls' => $tiny_urls,
            'limit' => $limit
        ]);
    }

    /**
     * Fetch the top 100 URLs 
     * @return JSONResponse
     */
    public function list(Request $request) {
        // Allow users to pick limit. Default to 100 entries
        $limit = 100;
        if ($request->query('limit') !== null) {
            $limit = (int)$request->query('limit');
        }

        // Fetch TinyUrls ordered by hit count
        $tiny_urls = TinyUrl::orderBy('hits', 'desc')
                                ->limit($limit)
                                ->get();
    
        // Only map relevant fields for the response
        $res = array_map(function ($tiny_url) {
            return (object)[
                'tiny_url' => config('app.url') . '/' . $tiny_url['id'],
                'full_url' => $tiny_url['full_url'],
                'hits' => $tiny_url['hits']
            ];
        }, $tiny_urls->toArray());

        return response()->json($res);
    }

    /**
     * Create a new tiny URL
     * @return JSONResponse
     */
    public function create(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'url' => 'required|url|max:512'
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->messages(), Response::HTTP_BAD_REQUEST);
        }

        // Fetch last seed used in a hash
        $last_seed = TinyUrl::max('seed');

        // Create the ID
        $id = $this->generateHash($request->url, ++$last_seed);

        // Keep trying different seeds if an id collision is found
        $collision_count = 0;
        while (TinyUrl::where('id', $id)->exists()) {
            $collision_count++;
            $id = $this->generateHash($request->url, ++$last_seed);
            if ($collision_count > 5) {
                return response()->json([
                    'id' => [
                        'Failed to generate a tiny URL. Could not generate a unique ID'
                    ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        
        // Create a new TinyUrl
        $tiny_url = TinyUrl::create([
            'id' => $id,
            'full_url' => $request->url
        ]);

        $tiny_url->save();

        return response()->json([
            'tiny_url' => config('app.url') . '/' . $id
        ]);
    }

    /**
     * Hit the tiny URL
     * Should increment hit count and redirect to full URL
     * @return RedirectResponse
     */
    public function hit(Request $request, $id) {
        // Find the right tiny URL
        $tiny_url = TinyUrl::where('id', $id)->firstOrFail();

        // Update hit count
        $tiny_url->update(['hits' => ++$tiny_url->hits]);
        $tiny_url->save();

        return redirect()->away($tiny_url->full_url);
    }

    /**
     * Delete a tiny URL by ID
     * @return Response
     */
    // public function delete(Request $request) {

    // }

    /**
     * Generate an md5 hash, base64 encoded and return the first 7 characters
     * @return string
     */
    private function generateHash($url, $seed) {
        $key = $seed . $url;
        $hash = md5($key);
        $hash = base64_encode($hash);
        return substr($hash, 0, 7);
    }
}
