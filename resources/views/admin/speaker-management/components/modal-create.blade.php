<div class="modal fade" id="addnewspeakermodal" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Add Speaker Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createSpeakerForm">
                    @csrf  <!-- CSRF Token for security -->
                    <div class="row g-3">
                        <div class="col-xxl-12">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name">
                            <span class="invalid-feedback" id="first_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-12">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Enter middle name">
                            <span class="invalid-feedback" id="middle_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-10">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter last name">
                            <span class="invalid-feedback" id="last_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-2">
                            <label for="suffix" class="form-label">Suffix</label>
                            <input type="text" class="form-control" name="suffix" id="suffix" placeholder="Enter suffix">
                            <span class="invalid-feedback" id="suffix_error" role="alert"></span>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-secondary"> <i class="ri-user-add-fill"></i> Add new speaker</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
