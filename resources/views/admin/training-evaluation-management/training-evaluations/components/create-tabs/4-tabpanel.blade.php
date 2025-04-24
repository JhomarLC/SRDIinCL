<div class="tab-pane fade" id="pills-personal-info" role="tabpanel"
aria-labelledby="pills-personal-info-tab">
<div>

    <h5>Personal Information</h5>
    <p class="text-muted">Fill all information below</p>
</div>

<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-3">
            <label for="first_name" class="form-label">First name</label>
            <input type="text" class="form-control" id="first_name" name="first_name"
                placeholder="Enter first name" value="">
            <div class="invalid-feedback">Please enter a first name</div>
        </div>

        <div class="col-sm-3">
            <label for="middle_name" class="form-label">Middle name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name"
                placeholder="Enter middle name" value="">
            <div class="invalid-feedback">Please enter a middle name</div>
        </div>

        <div class="col-sm-3">
            <label for="last_name" class="form-label">Last name</label>
            <input type="text" class="form-control" id="last_name" name="last_name"
                placeholder="Enter last name" value="">
            <div class="invalid-feedback">Please enter a last name</div>
        </div>
        <div class="col-sm-3">
            <label for="suffix" class="form-label">Suffix</label>
            <input type="text" class="form-control" id="suffix" name="suffix"
                placeholder="Enter Suffix" value="">
            <div class="invalid-feedback">Please enter Suffix</div>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="gender" class="form-label">Sex <span class="text-danger">*</span></label>
            <select class="form-control mb-3 select2" id="sex" name="sex">
                <option selected disabled hidden>-- SELECT SEX --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <div class="invalid-feedback">Please select gender</div>
        </div>
        <div class="col-sm-6" >
            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
            <select class="form-control select2" id="province" name="province_code" aria-label="Default select example">
                <option selected disabled hidden>-- SELECT PROVINCE --</option>
            </select>
            <div class="invalid-feedback">Please select province</div>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6">
            <label class="form-label d-block">Age Group <span class="text-danger">*</span></label>
            <div class="d-flex flex-wrap gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="below18" value="below 18">
                    <label class="form-check-label" for="below18">below 18</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="18to30" value="18-30">
                    <label class="form-check-label" for="18to30">18-30</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="31to45" value="31-45">
                    <label class="form-check-label" for="31to45">31-45</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="46to59" value="46-59">
                    <label class="form-check-label" for="46to59">46-59</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="60above" value="60 and above">
                    <label class="form-check-label" for="60above">60 and Above</label>
                </div>
            </div>
            <div class="invalid-feedback">Please select age group</div>
        </div>
        <div class="col-sm-6" >
            <label for="primary_sector" class="form-label">Primary sector involved in <span class="text-danger">*</span></label>
            <select class="form-control select2" id="primary_sector" name="primary_sector" aria-label="Default select example">
                <option selected disabled hidden>-- SELECT PRIMARY SECTOR --</option>
                <option value="Farmer/Seed Grower" selected>Farmer or Seed grower</option>
                <option value="Extension Worker">Extension workers and other intermediaries (e.g. LFT, trainer, extension worker)</option>
                <option value="Researcher">Researcher</option>
                <option value="Educator">Educator (elementary/high school/college teachers)</option>
                <option value="Student">Student (e.g. college student, post-graduate student)</option>
                <option value="Policy Maker">Policy maker (e.g. local chief executive)</option>
                <option value="Media">Media (e.g. broadcaster, vlogger, etc)</option>
                <option value="Industry Player">Industry Player (e.g. trader, miller, wholesaler, retailer)</option>
                <option value="Others">Other (e.g. OFW, job seeker, freelancer, consultant)</option>
            </select>
            <div class="invalid-feedback">Please select civil primary sector</div>
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
