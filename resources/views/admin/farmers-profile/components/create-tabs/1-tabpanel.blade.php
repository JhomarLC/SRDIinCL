<div class="tab-pane fade show active" id="pills-personal-info" role="tabpanel"
aria-labelledby="pills-personal-info-tab">
<div>
    <div>
        <h5>Personal Information</h5>
        <p class="text-muted">Fill all information below</p>
    </div>
    <div>
        <div class="row g-3">
            <div class="col-sm-3">
                <label for="first_name" class="form-label">First name</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                    placeholder="Enter first name">
                <div class="invalid-feedback">Please enter a first name</div>
            </div>

            <div class="col-sm-3">
                <label for="middle_name" class="form-label">Middle name</label>
                <input type="text" class="form-control" id="middle_name"
                    placeholder="Enter middle name">
                <div class="invalid-feedback">Please enter a middle name</div>
            </div>

            <div class="col-sm-3">
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    placeholder="Enter last name">
                <div class="invalid-feedback">Please enter a last name</div>
            </div>
            <div class="col-sm-3">
                <label for="suffix" class="form-label">Suffix</label>
                <input type="text" class="form-control" id="suffix" name="suffix"
                    placeholder="Enter Suffix">
                <div class="invalid-feedback">Please enter Suffix</div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-3">
                <label for="nickname" class="form-label">Nickname</label>
                <input type="text" class="form-control" id="nickname"
                    placeholder="Enter Nickname">
                <div class="invalid-feedback">Please enter Nickname</div>
            </div>
            <div class="col-sm-3">
                <label for="birth_date" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date">
                <div class="invalid-feedback">Please enter Birthdate</div>
            </div>
            <div class="col-sm-3">
                <label for="age_label" class="form-label">Age</label>
                <input type="text" class="form-control" id="age_label"
                    placeholder="Enter Birtdate to see Age" disabled>
                <div class="invalid-feedback">Please enter Age</div>
            </div>
            <!-- Hidden input to store age value -->
            <input type="hidden" name="age" id="age">
            <!-- Hidden input to store age group -->
            <input type="hidden" name="age_group" id="age_group">

            <div class="col-sm-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control mb-3 select2" id="gender" name="gender">
                    <option selected disabled hidden>-- SELECT GENDER --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <div class="invalid-feedback">Please select gender</div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-3" >
                <label for="civil_status" class="form-label">Civil Status</label>
                <select class="form-control select2" id="civil_status" name="civil_status">
                    <option selected disabled hidden>-- SELECT CIVIL STATUS --</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Separated">Separated</option>
                    <option value="Widow">Widow</option>
                    <option value="Divorced">Divorced</option>
                </select>
                <div class="invalid-feedback">Please select civil status</div>
            </div>
            <div class="col-sm-3">
                <label for="religion" class="form-label">Religion</label>
                <input type="text" class="form-control" id="religion" name="religion" placeholder="Enter Religion" >
                <div class="invalid-feedback">Please enter religion</div>
            </div>
            <div class="col-sm-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" >
                <div class="invalid-feedback">Please enter Phone Number</div>
            </div>
            <div class="col-sm-3" >
                <label for="education_level" class="form-label">Highest Level of Education</label>
                <select class="form-control select2" id="education_level" name="education_level" aria-label="Default select example">
                    <option selected disabled hidden>-- SELECT EDUCATION --</option>
                    <option value="Elementary">Elementary</option>
                    <option value="High School">High School</option>
                    <option value="Vocational">Vocational</option>
                    <option value="College Degree">College Degree</option>
                    <option value="Master's Degree">Master's Degree</option>
                    <option value="Doctorate Degree">Doctorate Degree</option>
                    <option value="Undergraduate">Undergraduate</option>
                    <option value="Others">Others</option>
                </select>

                <div class="invalid-feedback">Please select civil education</div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-3">
                <label for="is_pwd" class="form-label">Has a disability (PWD)</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_pwd" id="disabilityYes" value="1">
                    <label class="form-check-label" for="disabilityYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_pwd" id="disabilityNo" value="0" checked>
                    <label class="form-check-label" for="disabilityNo">No</label>
                </div>
            </div>

            <!-- Disability Selection Dropdown -->
            <div class="col-sm-3" id="disabilitySelectContainer" >
                <label for="disability" class="form-label">If Yes, Select Disability</label>
                <select class="form-control mb-3 select2" id="disability" name="disability" aria-label="Default select example" disabled>
                    <option selected disabled hidden>-- SELECT DISABILITY --</option>
                    <option value="Visual Impairment">1 - Visual Impairment</option>
                    <option value="Hearing Loss">2 - Hearing Loss</option>
                    <option value="Orthopedic Disability">3 - Orthopedic Disability</option>
                    <option value="Learning Disability">4 - Learning Disability</option>
                    <option value="Psychological Disability">5 - Psychological Disability</option>
                    <option value="Chronic Illness">6 - Chronic Illness</option>
                    <option value="Mental Disability">7 - Mental Disability</option>
                </select>
                <div class="invalid-feedback">Please select civil disability</div>
            </div>

            <div class="col-sm-3">
                <label for="is_indigenous" class="form-label">Indigenous People (IP):</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_indigenous" id="IPYes" value="1">
                    <label class="form-check-label" for="IPYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_indigenous" id="IPNo" value="0" checked>
                    <label class="form-check-label" for="IPNo">No</label>
                </div>
            </div>

            <!-- Tribe Name Input (Hidden by Default) -->
            <div class="col-sm-3" id="tribeContainer" >
                <label for="tribe_name" class="form-label">Name of Tribe</label>
                <input type="text" class="form-control" id="tribe_name" name="tribe_name" placeholder="Enter Tribe" disabled>
                <div class="invalid-feedback">Please enter Tribe</div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <hr>
        <h5>Address</h5>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-4" >
                <label for="civilStatus" class="form-label">Province</label>
                <select class="form-control select2" id="province" name="province" aria-label="Default select example">
                    <option selected disabled hidden>-- SELECT PROVINCE --</option>
                </select>
                <div class="invalid-feedback">Please select province</div>
            </div>
            <div class="col-sm-4" >
                <label for="civilStatus" class="form-label">Municipality</label>
                <select class="form-control select2" id="municipality" name="municipality" aria-label="Default select example" disabled>
                    <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                </select>
                <div class="invalid-feedback">Please select civil municipality</div>
            </div>
            <div class="col-sm-4" >
                <label for="barangay" class="form-label">Barangay</label>
                <select class="form-control select2" id="barangay" name="barangay" aria-label="Default select example" disabled>
                    <option selected disabled hidden>-- SELECT BARANGAY --</option>
                </select>
                <div class="invalid-feedback">Please select civil barangay</div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-9">
                <label for="house_number_sitio_purok" class="form-label">House Number/Sitio/Purok</label>
                <input type="text" class="form-control" id="house_number_sitio_purok" name="house_number_sitio_purok" placeholder="Enter House Number" >
                <div class="invalid-feedback">Please enter House Number/Sitio/Purok</div>
            </div>
            <div class="col-sm-3">
                <label for="zip_code" class="form-label">Zip Code</label>
                <input type="number" class="form-control" id="zip_code" name="zip_code" placeholder="Enter Zip Code" >
                <div class="invalid-feedback">Please enter Zip Code</div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <hr>
        <h5>Other Details</h5>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-4" >
                <label for="primary_sector" class="form-label">Primary sector involved in</label>
                <select class="form-control select2" id="primary_sector" name="primary_sector" aria-label="Default select example">
                    <option selected disabled hidden>-- SELECT PRIMARY SECTOR --</option>
                    <option value="Farmer/Seed Grower">Farmer or Seed grower</option>
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
            <div class="col-sm-4">
                <label for="years_in_farming" class="form-label">Number of years in Rice Farming</label>
                <input type="number" class="form-control" id="years_in_farming" name="years_in_farming" placeholder="Enter Number of Years in Rice Farming" >
                <div class="invalid-feedback">Please enter Years in Rice Farming</div>
            </div>
            <div class="col-sm-4">
                <label for="farmer_association" class="form-label">Farmers' Association</label>
                <input type="text" class="form-control" id="farmer_association" name="farmer_association" placeholder="Enter Farmers' Association" >
                <div class="invalid-feedback">Please enter Farmers' Association</div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-6" >
                <label for="farm_role" class="form-label">Farm Ownership Status</label>
                <select class="form-control select2" id="farm_role" aria-label="Default select example">
                    <option selected disabled hidden>-- SELECT FARM OWNERSHIP STATUS --</option>
                    <option value="Farm Owner">Owner/Farm Owner</option>
                    <option value="Relative of Farm Owner">Relative of the Owner/Farm Owner</option>
                </select>
                <div class="invalid-feedback">Please select ownership status</div>
            </div>
            <div class="col-sm-6">
                <label for="rsbsa_number" class="form-label">RSBSA Number</label>
                <input type="text" class="form-control" id="rsbsa_number" name="rsbsa_number" placeholder="Enter Farmers' Association" >
                <div class="invalid-feedback">Please enter RSBSA Number</div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-trainings-tab"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
</div>
</div>
<!-- end tab pane -->
