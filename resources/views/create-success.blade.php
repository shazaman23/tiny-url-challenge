<x-app>
    <x-slot name="title">
        | New URL
    </x-slot>

    <h2 class="title-head text-center">Here you go!</h2>

    <div class="flex">
        <div class="flex-1 text-center"><a href="{{ $url->tiny_url }}">{{ $url->tiny_url }}</a></div>
    </div>
</x-app>