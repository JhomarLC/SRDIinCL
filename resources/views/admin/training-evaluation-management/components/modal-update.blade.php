<div class="modal fade" id="editTrainingEventModal" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Update Training Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <form id="updateTrainingEventForm" method="POST">
                    @csrf  <!-- CSRF Token for security -->
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-xxl-12">
                            <label for="training_title" class="form-label">Training Title <span class="text-danger">*</span></label>
                            <input type="text" hidden id="edit_id">
                            <input type="text" class="form-control" name="training_title" id="update_training_title" value="Training on Pests and Nutrient Management (PNM)" disabled>
                            <span class="invalid-feedback" id="update_training_title_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-12">
                            <label for="training_date" class="form-label">Training Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="update_training_date" name="training_date">
                        </div>
                        <div class="col-xxl-12">
                            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_province" name="province">
                                <option selected disabled hidden>-- SELECT PROVINCE --</option>
                            </select>
                            <span class="invalid-feedback" id="update_province_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-12">
                            <label for="municipality" class="form-label">Municipality <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_municipality" name="municipality" disabled>
                                <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                            </select>
                            <span class="invalid-feedback" id="update_municipality_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-12">
                            <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_barangay" name="barangay" disabled>
                                <option selected disabled hidden>-- SELECT BARANGAY --</option>
                            </select>
                            <span class="invalid-feedback" id="update_barangay_error" role="alert"></span>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"> <i class="ri-user-follow-fill"></i> Update training event</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
