<x-app>
    <h1 class="text-center">Top {{ $limit }} URLs</h1>

    <ol class="url-list">
        @foreach($tiny_urls as $url)
            <li>
                <div class="flex spaced">
                    <div class="flex-1"><a href="{{ $url->tiny_url }}">{{ $url->tiny_url }}</a> --> {{ $url->full_url }}</div>
                    <div>({{ $url->hits }} Hits)</div>
                </div>
            </li>
        @endforeach
    </ol>
</x-app>