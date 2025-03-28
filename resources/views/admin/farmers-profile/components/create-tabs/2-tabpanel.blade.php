<div class="tab-pane fade" id="pills-trainings" role="tabpanel"
aria-labelledby="pills-trainings-tab">
    <div class="d-flex align-items-center">
            <h5 class="flex-grow-1">Trainings on rice farming attended in the past five (5) years</h5>
            <button id="addTrainingBtn" class="btn btn-secondary">
                <i class="ri-add-line"></i> Add Training
            </button>
    </div>

    <p class="text-muted">Fill all information below</p>
    <!-- Add this wrapper around the form fields -->
    <div id="trainingContainer">
        <div class="training-entry position-relative border p-3 mb-4">
            <!-- Inside each .training-entry -->
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-training d-none">
                Remove
            </button>
            <div class="mt-3">
                <div class="row g-3">
                    <div class="col-sm-7">
                        <label for="training_title" class="form-label">Title of the training/workshop</label>
                        <input type="text" class="form-control" id="training_title" name="training_title[0]" value="Sample Title"
                            placeholder="Enter title of the training/workshop"  >
                        <div class="invalid-feedback">Please enter training title</div>
                    </div>
                    <div class="col-sm-5">
                        {{-- <label for="training_year" class="form-label">Date</label> --}}
                            <label for="training_date" class="form-label">Training Date</label>
                            <input type="date" class="form-control" id="training_year" name="training_year[0]" value="2025-01-20">

                        <div class="invalid-feedback">Please select year conducted</div>
                            {{-- <div class="invalid-feedback">Please enter Birthdate</div> --}}
                        {{-- <select class="form-control mb-3 select2" name="training_year[0]" aria-label="Default select example">
                            <option selected disabled hidden>-- SELECT YEAR --</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select> --}}
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row g-3">
                    <div class="col-sm-7">
                        <label for="conducted_by " class="form-label">Group or agency that conducted the training</label>
                        <input type="text" class="form-control" id="conducted_by" name="conducted_by[0]"
                            placeholder="Enter group of agency that conducted the training" value="Philrice" >
                        <div class="invalid-feedback">Please enter training title</div>
                    </div>
                    <div class="col-sm-5">
                        <label for="payForTraining" class="form-label">Did you personally pay for attending the training?</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="personally_paid[0]" id="paid_yes" value="yes">
                            <label class="form-check-label" for="paid_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="personally_paid[0]" id="paid_no" value="no" checked>
                            <label class="form-check-label" for="paid_no">No</label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <hr>

    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label previestab"
            data-previous="pills-personal-info-tab"><i
                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
            Previous
        </button>
        <button type="button" class="btn btn-success btn-label right ms-auto nexttab"
            data-nexttab="pills-other-info-tab"><i
                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
            Next
        </button>
    </div>
</div>
<!-- end tab pane -->
