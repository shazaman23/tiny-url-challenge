<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TinyUrlController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TinyUrlController::class, 'index']);
Route::get('/new', [TinyUrlController::class, 'showCreateView']);
Route::post('/new', [TinyUrlController::class, 'handleCreateForm']);
Route::get('/{id}', [TinyUrlController::class, 'hitUrl']);