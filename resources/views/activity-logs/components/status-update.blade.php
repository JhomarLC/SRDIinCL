 <!-- Modal -->
 <div class="modal fade zoomIn" id="activateAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="deleteRecord-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <script src="https://cdn.lordicon.com/lordicon.js"></script>
                    <lord-icon
                        src="https://cdn.lordicon.com/lltgvngb.json"
                        trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548"
                        style="width:100px;height:100px">
                    </lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you Sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to activate AEW account?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <form id="activateAEWForm" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="text" hidden id="activate-edit-id">
                        <button type="submit" class="btn w-sm btn-danger">Yes, Activate It!</button>
                    </form>

                </div>
            </div>

        </div><!-- /.modal-content -->
    </div>
</div>
<!--end modal -->

<!-- Modal -->
<div class="modal fade zoomIn" id="deactivateAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="deleteRecord-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <script src="https://cdn.lordicon.com/lordicon.js"></script>
                    <lord-icon
                        src="https://cdn.lordicon.com/lltgvngb.json"
                        trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548"
                        style="width:100px;height:100px">
                    </lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you Sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to disable AEW account?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <form id="deactivateAEWForm" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="text" hidden id="deactivate-edit-id">
                        <button type="submit" class="btn w-sm btn-danger">Yes, Disable It!</button>
                    </form>

                </div>
            </div>

        </div><!-- /.modal-content -->
    </div>
</div>
<!--end modal -->
