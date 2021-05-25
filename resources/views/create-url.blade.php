<x-app>
    <x-slot name="title">
        | Create
    </x-slot>

    <h1 class="title-head text-center">Create Tiny URL</h1>

    <form class="main-form" method="POST" action="/new">
        @csrf
        <div class="form-group">
            <label for="url"><strong>Destination URL</strong></label>
            <input id="url" class="form-control @error('url') is-invalid @enderror" type="text" name="url" placeholder="https://google.com" value="{{ old('url') }}">
            <span class="help-block">
                Enter the URL you want to tiny-ify (Must be a valid URL)
            </span>
            @error('url')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-check form-group">
            <input id="nsfw" class="form-check-input @error('nsfw') is-invalid @enderror" type="checkbox" name="nsfw" value="true">
            <label class="form-check-label" for="nsfw"><strong>Is this URL Not Safe For Work (NSFW)?</strong></label>
            @error('nsfw')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        @error('id')
            <div class="form-group">
                <div class="is-invalid">
                </div>
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            </div>
        @enderror
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</x-app>