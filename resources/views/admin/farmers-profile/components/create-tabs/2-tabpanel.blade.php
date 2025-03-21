<div class="tab-pane fade" id="pills-trainings" role="tabpanel"
aria-labelledby="pills-trainings-tab">
<div class="d-flex align-items-center">
        <h5 class="flex-grow-1">Trainings on rice farming attended in the past five (5) years</h5>
        <button class="btn btn-secondary">
            <i class="ri-add-line"></i> Add Training
        </button>
</div>

<p class="text-muted">Fill all information below</p>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-7">
            <label for="trainingTitle" class="form-label">Title of the training/workshop</label>
            <input type="text" class="form-control" id="trainingTitle"
                placeholder="Enter title of the training/workshop" value="" required>
            <div class="invalid-feedback">Please enter training title</div>
        </div>
        <div class="col-sm-5">
            <label for="yearTrainingConducted" class="form-label">Year Conducted</label>
            <select class="form-control mb-3 select2" aria-label="Default select example">
                <option selected disabled hidden>-- SELECT YEAR --</option>
                <option value="1">2023</option>
                <option value="2">2024</option>
                <option value="2">2025</option>
            </select>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-7">
            <label for="agencyConducted" class="form-label">Group or agency that conducted the training</label>
            <input type="text" class="form-control" id="agencyConducted"
                placeholder="Enter group of agency that conducted the training" value="" required>
            <div class="invalid-feedback">Please enter training title</div>
        </div>
        <div class="col-sm-5">
            <label for="payForTraining" class="form-label">Did you personally pay for attending the training?</label>
            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="radio" name="indigenousPeople" id="IPYes" value="yes">
                <label class="form-check-label" for="IPYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="indigenousPeople" id="IPNo" value="no" checked>
                <label class="form-check-label" for="IPNo">No</label>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-personal-info-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous</button>
    <button type="button"
        class="btn btn-success btn-label right ms-auto nexttab nexttab"
        data-nexttab="pills-other-info-tab"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
</div>
</div>
<!-- end tab pane -->
