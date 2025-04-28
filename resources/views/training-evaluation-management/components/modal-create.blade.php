<div class="modal fade" id="addnewtrainingeventsmodal" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Add Training Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createTrainingEventForm">
                    @csrf  <!-- CSRF Token for security -->
                    <div class="row g-3">
                        <div class="col-xxl-12">
                            <label for="training_title" class="form-label">Training Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="training_title" id="training_title" value="Training on Pests and Nutrient Management (PNM)" disabled>
                            <span class="invalid-feedback" id="training_title_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-12">
                            <label for="training_date" class="form-label">Training Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="training_date" name="training_date">
                        </div>
                        <div class="col-xxl-12">
                            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="province" name="province">
                                <option selected disabled hidden>-- SELECT PROVINCE --</option>
                            </select>
                            <span class="invalid-feedback" id="province_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-12">
                            <label for="municipality" class="form-label">Municipality <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="municipality" name="municipality" disabled>
                                <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                            </select>
                            <span class="invalid-feedback" id="municipality_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-12">
                            <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="barangay" name="barangay" disabled>
                                <option selected disabled hidden>-- SELECT BARANGAY --</option>
                            </select>
                            <span class="invalid-feedback" id="barangay_error" role="alert"></span>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-secondary"> <i class="ri-file-add-fill"></i> Add new training event</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
