<div class="tab-pane fade" id="pills-training-result" role="tabpanel"
aria-labelledby="pills-training-result-tab">
<div>

    <h5>Personal Information</h5>
    <p class="text-muted">Fill all information below</p>
</div>

<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-3">
            <label for="first_name" class="form-label">First name</label>
            <input type="text" class="form-control" id="first_name"
                placeholder="Enter first name" value="" required>
            <div class="invalid-feedback">Please enter a first name</div>
        </div>

        <div class="col-sm-3">
            <label for="middle_name" class="form-label">Middle name</label>
            <input type="text" class="form-control" id="middle_name"
                placeholder="Enter middle name" value="" required>
            <div class="invalid-feedback">Please enter a middle name</div>
        </div>

        <div class="col-sm-3">
            <label for="last_name" class="form-label">Last name</label>
            <input type="text" class="form-control" id="last_name"
                placeholder="Enter last name" value="" required>
            <div class="invalid-feedback">Please enter a last name</div>
        </div>
        <div class="col-sm-3">
            <label for="suffix" class="form-label">Suffix</label>
            <input type="text" class="form-control" id="suffix"
                placeholder="Enter Suffix" value="" required>
            <div class="invalid-feedback">Please enter Suffix</div>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-3">
            <label for="sex" class="form-label">Sex</label>
            <select class="form-control select2" id="sex" aria-label="Default select example">
                <option selected disabled hidden>-- SELECT SEX --</option>
                <option value="1">Male</option>
                <option value="2">Female</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label for="age" class="form-label">Age</label>
            <input type="text" class="form-control" id="age"
                placeholder="Enter Age" value="" required>
            <div class="invalid-feedback">Please enter Age</div>
        </div>
        <div class="col-sm-6" >
            <label for="sector" class="form-label">Primary sector involved in</label>
            <select class="form-control select2" id="sector" aria-label="Default select example">
                <option selected disabled hidden>-- SELECT PRIMARY SECTOR --</option>
                <option value="1">Farmer or Seed grower</option>
                <option value="2">Extension workers and other intermediaries (e.g. LFT, trainer, extension worker)</option>
                <option value="3">Researcher</option>
                <option value="3">Educator (elementary/high school/college teachers)</option>
                <option value="3">Student (e.g. college student, post-graduate student)</option>
                <option value="3">Policy maker (e.g. local chief executive)</option>
                <option value="3">Media (e.g. broadcaster, vlogger, etc)</option>
                <option value="3">Industry Player (e.g. trader, miller, wholesaler, retailer)</option>
                <option value="3">Other (e.g. OFW, job seeker, freelancer, consultant)</option>
            </select>
        </div>
    </div>
</div>


<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-emergency-contact-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous</button>
    <button type="button"
        class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-bill-finish"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
        Finish</button>
</div>
</div>
