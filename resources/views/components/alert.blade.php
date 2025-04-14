@if(session('success') || session('error') || session('pending'))
<!-- Dynamic Alert-Like Modal -->
<div id="alertModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-5">

                @if (session('success'))
                    <lord-icon
                        src="https://cdn.lordicon.com/lupuorrc.json"
                        trigger="loop"
                        colors="primary:#121331,secondary:#08a88a"
                        style="width:120px;height:120px">
                    </lord-icon>
                @elseif (session('error'))
                    <script src="https://cdn.lordicon.com/lordicon.js"></script>
                    <lord-icon
                        src="https://cdn.lordicon.com/lltgvngb.json"
                        trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548"
                        style="width:120px;height:120px">
                    </lord-icon>
                @elseif (session('pending'))
                    <script src="https://cdn.lordicon.com/lordicon.js"></script>
                    <lord-icon
                        src="https://cdn.lordicon.com/warimioc.json"
                        trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548"
                        style="width:120px;height:120px">
                    </lord-icon>
                @endif

                <div class="mt-4">
                    <h4 class="mb-3">
                        @if (session('success')) Success!
                        @elseif (session('error')) Error!
                        @elseif (session('pending')) Pending Account!
                        @endif
                    </h4>
                    <p class="text-muted mb-4">
                        @if(session('success')) {{ session('success') }}
                        @elseif(session('error')) {{ session('error') }}
                        @elseif(session('pending')) {{ session('pending') }}
                        @endif
                    </p>
                    <div class="hstack gap-2 justify-content-center">
                        @if(session('success'))
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Got it!</button>
                        @elseif(session('error'))
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Got it!</button>
                        @elseif(session('pending'))
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Okay</button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Auto-Show Modal -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var alertModal = document.getElementById('alertModal');
        if (alertModal) {
            var myModal = new bootstrap.Modal(alertModal);
            myModal.show();
        }
    });
</script>
@endif
