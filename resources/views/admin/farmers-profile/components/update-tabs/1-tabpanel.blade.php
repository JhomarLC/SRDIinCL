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
                    value="{{ old('first_name', $participant->first_name ?? '') }}"
                    placeholder="Enter first name">
                <div class="invalid-feedback">Please enter a first name</div>
            </div>

            <div class="col-sm-3">
                <label for="middle_name" class="form-label">Middle name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name"
                    value="{{ old('middle_name', $participant->middle_name ?? '') }}"
                    placeholder="Enter middle name">
                <div class="invalid-feedback">Please enter a middle name</div>
            </div>

            <div class="col-sm-3">
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    value="{{ old('last_name', $participant->last_name ?? '') }}"
                    placeholder="Enter last name">
                <div class="invalid-feedback">Please enter a last name</div>
            </div>
            <div class="col-sm-3">
                <label for="suffix" class="form-label">Suffix</label>
                <input type="text" class="form-control" id="suffix" name="suffix"
                    value="{{ old('suffix', $participant->suffix ?? '') }}"
                    placeholder="Enter Suffix">
                <div class="invalid-feedback">Please enter Suffix</div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-3">
                <label for="nickname" class="form-label">Nickname</label>
                <input type="text" class="form-control" id="nickname" name="nickname"
                    value="{{ old('nickname', $participant->nickname ?? '') }}"
                    placeholder="Enter Nickname">
                <div class="invalid-feedback">Please enter Nickname</div>
            </div>
            <div class="col-sm-3">
                <label for="birth_date" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date"
                    value="{{ old('birth_date', $participant->birth_date ?? '') }}">
                <div class="invalid-feedback">Please enter Birthdate</div>
            </div>
            <div class="col-sm-3">
                <label for="age_label" class="form-label">Age</label>
                <input type="text" class="form-control" id="age_label"
                    placeholder="Enter Birtdate to see Age"
                    value="{{ old('age_label', $participant->age . ' yrs old' ?? '') }}" disabled>
                <div class="invalid-feedback">Please enter Age</div>
            </div>
            <!-- Hidden input to store age value -->
            <input type="hidden" name="age" id="age"
                value="{{ old('age', $participant->age ?? '') }}">
            <!-- Hidden input to store age group -->
            <input type="hidden" name="age_group" id="age_group"
                value="{{ old('age_group', $participant->age_group ?? '') }}">

            <div class="col-sm-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control mb-3 select2" id="gender" name="gender">
                    <option disabled hidden>-- SELECT GENDER --</option>
                    <option value="Male" {{ old('gender', $participant->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $participant->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
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
                    <option disabled hidden>-- SELECT CIVIL STATUS --</option>
                    <option value="Single" {{ old('civil_status', $participant->civil_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married"{{ old('civil_status', $participant->civil_status ?? '') == 'Maried' ? 'selected' : '' }}>Married</option>
                    <option value="Separated" {{ old('civil_status', $participant->civil_status ?? '') == 'Separated' ? 'selected' : '' }}>Separated</option>
                    <option value="Widow" {{ old('civil_status', $participant->civil_status ?? '') == 'widow' ? 'selected' : '' }}>Widow</option>
                    <option value="Divorced" {{ old('civil_status', $participant->civil_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                </select>
                <div class="invalid-feedback">Please select civil status</div>
            </div>
            <div class="col-sm-3">
                <label for="religion" class="form-label">Religion</label>
                <input type="text" class="form-control" id="religion" name="religion" placeholder="Enter Religion"
                    value="{{ old('religion', $participant->religion ?? '') }}">
                <div class="invalid-feedback">Please enter religion</div>
            </div>
            <div class="col-sm-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number"
                    value="{{ old('phone_number', $participant->phone_number ?? '') }}">
                <div class="invalid-feedback">Please enter Phone Number</div>
            </div>
            <div class="col-sm-3" >
                <label for="education_level" class="form-label">Highest Level of Education</label>
                <select class="form-control select2" id="education_level" name="education_level" aria-label="Default select example">
                    <option selected disabled hidden>-- SELECT EDUCATION --</option>
                    <option value="Elementary"  {{ old('education_level', $participant->education_level ?? '') == 'Elementary' ? 'selected' : '' }}>Elementary</option>
                    <option value="High School"  {{ old('education_level', $participant->education_level ?? '') == 'High School' ? 'selected' : '' }}>High School</option>
                    <option value="Vocational"  {{ old('education_level', $participant->education_level ?? '') == 'Vocational' ? 'selected' : '' }}>Vocational</option>
                    <option value="College Degree"  {{ old('education_level', $participant->education_level ?? '') == 'College Degree' ? 'selected' : '' }}>College Degree</option>
                    <option value="Masters Degree"  {{ old('education_level', $participant->education_level ?? '') == `Masters Degree` ? 'selected' : '' }}>Masters Degree</option>
                    <option value="Doctorate Degree"  {{ old('education_level', $participant->education_level ?? '') == 'Doctorate Degree' ? 'selected' : '' }}>Doctorate Degree</option>
                    <option value="Undergraduate"  {{ old('education_level', $participant->education_level ?? '') == 'Undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                    <option value="Others"  {{ old('education_level', $participant->education_level ?? '') == 'Others' ? 'selected' : '' }}>Others</option>
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
                    <input class="form-check-input" type="radio" name="is_pwd" id="disabilityYes" value="1"
                        {{ old('is_pwd', $participant->is_pwd ?? '') == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="disabilityYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_pwd" id="disabilityNo" value="0"
                        {{ old('is_pwd', $participant->is_pwd ?? '') == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="disabilityNo">No</label>
                </div>
            </div>

            <!-- Disability Selection Dropdown -->
            <div class="col-sm-3" id="disabilitySelectContainer" >
                <label for="disability" class="form-label">If Yes, Select Disability</label>
                <select class="form-control mb-3 select2" id="disability_type" name="disability_type" aria-label="Default select example"
                    {{ old('disability_type', $participant->disability_type) == 0 ? 'disabled' : '' }}>
                    <option value="" disabled
                        {{ old('disability_type', $participant->disability_type ?? '') == '' ? 'selected' : '' }}>
                        -- SELECT DISABILITY --
                    </option>
                    <option value="Visual Impairment"
                         {{ old('disability_type', $participant->disability_type ?? '') == 'Visual Impairment' ? 'selected' : '' }}>
                         1 - Visual Impairment
                    </option>
                    <option value="Hearing Loss"
                         {{ old('disability_type', $participant->disability_type ?? '') == 'Hearing Loss' ? 'selected' : '' }}>
                        2 - Hearing Loss
                    </option>
                    <option value="Orthopedic Disability"
                         {{ old('disability_type', $participant->disability_type ?? '') == 'Orthopedic Disability' ? 'selected' : '' }}>
                        3 - Orthopedic Disability
                    </option>
                    <option value="Learning Disability"
                         {{ old('disability_type', $participant->disability_type ?? '') == 'Learning Disability' ? 'selected' : '' }}>
                        4 - Learning Disability
                    </option>
                    <option value="Psychological Disability"
                         {{ old('disability_type', $participant->disability_type ?? '') == 'Psychological Disability' ? 'selected' : '' }}>
                        5 - Psychological Disability
                    </option>
                    <option value="Chronic Illness"
                         {{ old('disability_type', $participant->disability_type ?? '') == 'Chronic Illness' ? 'selected' : '' }}>
                        6 - Chronic Illness
                    </option>
                    <option value="Mental Disability"
                         {{ old('disability_type', $participant->disability_type ?? '') == 'Mental Disability' ? 'selected' : '' }}>
                        7 - Mental Disability
                    </option>
                </select>
                <div class="invalid-feedback">Please select civil disability</div>
            </div>

            <div class="col-sm-3">
                <label for="is_indigenous" class="form-label">Indigenous People (IP):</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_indigenous" id="IPYes" value="1"
                        {{ old('is_indigenous', $participant->is_indigenous ?? '') == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="IPYes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_indigenous" id="IPNo" value="0"
                        {{ old('is_indigenous', $participant->is_indigenous ?? '') == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="IPNo">No</label>
                </div>
            </div>

            <!-- Tribe Name Input (Hidden by Default) -->
            <div class="col-sm-3" id="tribeContainer" >
                <input type="text" class="form-control" id="tribe_name" name="tribe_name"
                    value="{{ old('tribe_name', $participant->tribe_name ?? '') }}" placeholder="Enter Tribe" {{ old('is_indigenous', $participant->is_indigenous ?? '') == 0 ? 'disabled' : '' }}>
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
                <select class="form-control select2" id="update_province" name="province_code" aria-label="Default select example">
                    <option selected disabled hidden>-- SELECT PROVINCE --</option>
                </select>
                <div class="invalid-feedback">Please select province</div>
            </div>
            <div class="col-sm-4" >
                <label for="civilStatus" class="form-label">Municipality</label>
                <select class="form-control select2" id="update_municipality" name="municipality_code" aria-label="Default select example" disabled>
                    <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                </select>
                <div class="invalid-feedback">Please select civil municipality</div>
            </div>
            <div class="col-sm-4" >
                <label for="barangay" class="form-label">Barangay</label>
                <select class="form-control select2" id="update_barangay" name="barangay_code" aria-label="Default select example" disabled>
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
                <input type="text" class="form-control" id="house_number_sitio_purok" name="house_number_sitio_purok" placeholder="Enter House Number" value="{{ old('house_number_sitio_purok', $participant->house_number_sitio_purok ?? '') }}">
                <div class="invalid-feedback">Please enter House Number/Sitio/Purok</div>
            </div>
            <div class="col-sm-3">
                <label for="zip_code" class="form-label">Zip Code</label>
                <input type="number" class="form-control" id="zip_code" name="zip_code" placeholder="Enter Zip Code" value="{{ old('zip_code', $participant->zip_code ?? '') }}">
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
                    <option disabled hidden>-- SELECT PRIMARY SECTOR --</option>
                    <option value="Farmer/Seed Grower" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Farmer/Seed Grower' ? 'selected' : '' }}>Farmer or Seed grower</option>
                    <option value="Extension Worker" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Extension Worker' ? 'selected' : '' }}>Extension workers and other intermediaries (e.g. LFT, trainer, extension worker)</option>
                    <option value="Researcher" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Researcher' ? 'selected' : '' }}>Researcher</option>
                    <option value="Educator" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Educator' ? 'selected' : '' }}>Educator (elementary/high school/college teachers)</option>
                    <option value="Student" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Student' ? 'selected' : '' }}>Student (e.g. college student, post-graduate student)</option>
                    <option value="Policy Maker" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Policy Maker' ? 'selected' : '' }}>Policy maker (e.g. local chief executive)</option>
                    <option value="Media" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Media' ? 'selected' : '' }}>Media (e.g. broadcaster, vlogger, etc)</option>
                    <option value="Industry Player" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Industry Player' ? 'selected' : '' }}>Industry Player (e.g. trader, miller, wholesaler, retailer)</option>
                    <option value="Others" {{ old('primary_sector', $participant->primary_sector ?? '') == 'Others' ? 'selected' : '' }}>Other (e.g. OFW, job seeker, freelancer, consultant)</option>
                </select>
                <div class="invalid-feedback">Please select civil primary sector</div>
            </div>
            <div class="col-sm-4">
                <label for="years_in_farming" class="form-label">Number of years in Rice Farming</label>
                <input type="number" class="form-control" id="years_in_farming" name="years_in_farming" placeholder="Enter Number of Years in Rice Farming" value="{{ old('years_in_farming', $participant->years_in_farming ?? '') }}">
                <div class="invalid-feedback">Please enter Years in Rice Farming</div>
            </div>
            <div class="col-sm-4">
                <label for="farmer_association" class="form-label">Farmers' Association</label>
                <input type="text" class="form-control" id="farmer_association" name="farmer_association" placeholder="Enter Farmers' Association" value="{{ old('farmer_association', $participant->farmer_association ?? '') }}">
                <div class="invalid-feedback">Please enter Farmers' Association</div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="farm_role" class="form-label">Farm Ownership Status</label>
                <select class="form-control select2" id="farm_role" name="farm_role" aria-label="Default select example">
                    <option selected disabled hidden>-- SELECT FARM OWNERSHIP STATUS --</option>
                    <option value="Farm Owner" {{ old('farm_role', $participant->farm_role ?? '') == 'Farm Owner' ? 'selected' : '' }}>Owner/Farm Owner</option>
                    <option value="Relative of Farm Owner" {{ old('farm_role', $participant->farm_role ?? '') == 'Relative of Farm Owner' ? 'selected' : '' }}>Relative of the Owner/Farm Owner</option>
                </select>
                <div class="invalid-feedback">Please select ownership status</div>
            </div>
            <div class="col-sm-6">
                <label for="rsbsa_number" class="form-label">RSBSA Number</label>
                <input type="text" class="form-control" id="rsbsa_number" name="rsbsa_number" placeholder="Enter RSBSA Number" value="{{ old('rsbsa_number', $participant->rsbsa_number ?? '') }}">
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
