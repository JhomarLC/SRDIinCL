 <!-- Modal -->
 <div class="modal fade zoomIn" id="unarchiveEvalModal" tabindex="-1" aria-hidden="true">
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
                        <p class="text-muted mx-4 mb-0">Are you sure you want to unarchive training evaluation?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <form id="unarchiveEvalForm" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="text" hidden id="unarchive-edit-id">
                        <button type="submit" class="btn w-sm btn-danger">Yes, Unarchive It!</button>
                    </form>

                </div>
            </div>

        </div><!-- /.modal-content -->
    </div>
</div>
<!--end modal -->
<input type="hidden" id="training_event" value="{{ $training_event->id }}">
<!-- Modal -->
<div class="modal fade zoomIn" id="archiveEvalModal" tabindex="-1" aria-hidden="true">
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
                        <p class="text-muted mx-4 mb-0">Are you sure you want to archive training evaluation?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <form id="archiveEvalForm" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" id="speaker_id" value="{{ $speaker->id }}"> --}}
                        <input type="hidden" id="archive-edit-id">
                        <button type="submit" class="btn w-sm btn-danger">Yes, Archive It!</button>
                    </form>

                </div>
            </div>

        </div><!-- /.modal-content -->
    </div>
</div>
<!--end modal -->
