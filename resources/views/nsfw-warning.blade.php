<x-app>
    <x-slot name="title">
        | NSFW Warning!
    </x-slot>

    <div id="warningModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-header justify-center">
                    <h2 class="modal-title">NSFW Warning!</h2>
                </div>
                <div class="modal-body">
                    <p>
                        The link you clicked leads to a page that has been marked 
                        <strong>Not Safe For Work (NSFW)</strong>
                        Please close this tab if you do not want to be redirected at this time.
                    </p>
                    <p>
                        <strong>This page will redirect to the NSFW destination in 10 seconds!</strong>
                    </p>
                </div>
                <div class="modal-footer justify-center">
                    <a href="/"><button class="btn btn-danger">Wait! Go back!</button></a>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="extrajs">
        <script>
            var warningModal = new bootstrap.Modal(document.getElementById('warningModal'), {
                backdrop: true
            });
            warningModal.show();
            setTimeout(function() {
                location.replace("{{ $tiny_url->full_url }}");
            }, 10000);
        </script>
    </x-slot>
</x-app>