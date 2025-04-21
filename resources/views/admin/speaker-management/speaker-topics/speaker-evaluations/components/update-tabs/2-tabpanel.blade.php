<div class="tab-pane fade" id="pills-evaluation-personal-info" role="tabpanel"
aria-labelledby="pills-evaluation-personal-info-tab">
<div>

    <h5>Personal Information</h5>
    <p class="text-muted">Fill all information below</p>
</div>

<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-3">
            <label for="first_name" class="form-label">First name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="first_name" name="first_name"
                value="{{ old('first_name', $evaluation->speaker_evaluation_info->first_name) }}"
                placeholder="Enter first name" required>
            <div class="invalid-feedback">Please enter a first name</div>
        </div>

        <div class="col-sm-3">
            <label for="middle_name" class="form-label">Middle name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name"
                value="{{ old('middle_name', $evaluation->speaker_evaluation_info->middle_name) }}"
                placeholder="Enter middle name">
            <div class="invalid-feedback">Please enter a middle name</div>
        </div>

        <div class="col-sm-3">
            <label for="last_name" class="form-label">Last name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="last_name" name="last_name"
                value="{{ old('first_name', $evaluation->speaker_evaluation_info->first_name) }}"
                placeholder="Enter last name" required>
            <div class="invalid-feedback">Please enter a last name</div>
        </div>
        <div class="col-sm-3">
            <label for="suffix" class="form-label">Suffix</label>
            <input type="text" class="form-control" id="suffix" name="suffix"
                 value="{{ old('suffix', $evaluation->speaker_evaluation_info->suffix) }}"
                placeholder="Enter Suffix">
            <div class="invalid-feedback">Please enter Suffix</div>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="gender" class="form-label">Sex <span class="text-danger">*</span></label>
            <select class="form-control mb-3 select2" id="gender" name="gender">
                <option selected disabled hidden>-- SELECT GENDER --</option>
                <option value="Male" {{ $evaluation->speaker_evaluation_info->gender === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $evaluation->speaker_evaluation_info->gender === 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            <div class="invalid-feedback">Please select gender</div>
        </div>
        <div class="col-sm-6">
            <label class="form-label d-block">Age Group <span class="text-danger">*</span></label>
            <div class="d-flex flex-wrap gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="below18" value="below 18"
                    {{ $evaluation->speaker_evaluation_info->age_group === 'below 18' ? 'checked' : '' }}>
                    <label class="form-check-label" for="below18">below 18</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="18to30" value="18-30"
                    {{ $evaluation->speaker_evaluation_info->age_group === '18-30' ? 'checked' : '' }}>
                    <label class="form-check-label" for="18to30">18-30</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="31to45" value="31-45"
                    {{ $evaluation->speaker_evaluation_info->age_group === '31-45' ? 'checked' : '' }}>
                    <label class="form-check-label" for="31to45">31-45</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="46to59" value="46-59"
                    {{ $evaluation->speaker_evaluation_info->age_group === '46-59' ? 'checked' : '' }}>
                    <label class="form-check-label" for="46to59">46-59</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="60above" value="60 and above"
                    {{ $evaluation->speaker_evaluation_info->age_group === '60 and above' ? 'checked' : '' }}>
                    <label class="form-check-label" for="60above">60 and Above</label>
                </div>
            </div>
            <div class="invalid-feedback">Please select age group</div>
        </div>

    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6" >
            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
            <select class="form-control select2" id="update_province" name="province_code" aria-label="Default select example">
                <option selected disabled hidden>-- SELECT PROVINCE --</option>
            </select>
            <div class="invalid-feedback">Please select province</div>
        </div>
        <div class="col-sm-6" >
            <label for="primary_sector" class="form-label">Primary sector involved in <span class="text-danger">*</span></label>
            <select class="form-control select2" id="primary_sector" name="primary_sector" aria-label="Default select example">
                <option disabled hidden>-- SELECT PRIMARY SECTOR --</option>
                <option value="Farmer/Seed Grower" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Farmer/Seed Grower' ? 'selected' : '' }}>Farmer or Seed grower</option>
                <option value="Extension Worker" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Extension Worker' ? 'selected' : '' }}>Extension workers and other intermediaries (e.g. LFT, trainer, extension worker)</option>
                <option value="Researcher" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Researcher' ? 'selected' : '' }}>Researcher</option>
                <option value="Educator" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Educator' ? 'selected' : '' }}>Educator (elementary/high school/college teachers)</option>
                <option value="Student" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Student' ? 'selected' : '' }}>Student (e.g. college student, post-graduate student)</option>
                <option value="Policy Maker" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Policy Maker' ? 'selected' : '' }}>Policy maker (e.g. local chief executive)</option>
                <option value="Media" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Media' ? 'selected' : '' }}>Media (e.g. broadcaster, vlogger, etc)</option>
                <option value="Industry Player" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Industry Player' ? 'selected' : '' }}>Industry Player (e.g. trader, miller, wholesaler, retailer)</option>
                <option value="Others" {{ old('primary_sector', $evaluation->speaker_evaluation_info->primary_sector ?? '') == 'Others' ? 'selected' : '' }}>Other (e.g. OFW, job seeker, freelancer, consultant)</option>
            </select>
            <div class="invalid-feedback">Please select civil primary sector</div>
        </div>
    </div>
</div>

<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-3">
            <label for="is_pwd" class="form-label">Has a disability (PWD)</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_pwd" id="disabilityYes" value="1"
                {{ old('is_pwd', $evaluation->speaker_evaluation_info->is_pwd ?? '') == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="disabilityYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_pwd" id="disabilityNo" value="0"
                {{ old('is_pwd', $evaluation->speaker_evaluation_info->is_pwd ?? '') == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="disabilityNo">No</label>
            </div>
        </div>

        <!-- Disability Selection Dropdown -->
        <div class="col-sm-3" id="disabilitySelectContainer" >
            <label for="disability_type" class="form-label">If Yes, Select Disability</label>
            <select class="form-control mb-3 select2" id="disability_type" name="disability_type" aria-label="Default select example"
                {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type) == 0 ? 'disabled' : '' }}>
                <option value="" disabled
                {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type ?? '') == '' ? 'selected' : '' }}>
                    -- SELECT DISABILITY --
                </option>
                <option value="Visual Impairment"
                    {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type ?? '') == 'Visual Impairment' ? 'selected' : '' }}>
                    1 - Visual Impairment
                </option>
                <option value="Hearing Loss"
                    {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type ?? '') == 'Hearing Loss' ? 'selected' : '' }}>
                    2 - Hearing Loss
                </option>
                <option value="Orthopedic Disability"
                    {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type ?? '') == 'Orthopedic Disability' ? 'selected' : '' }}>
                    3 - Orthopedic Disability
                </option>
                <option value="Learning Disability"
                    {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type ?? '') == 'Learning Disability' ? 'selected' : '' }}>
                    4 - Learning Disability
                </option>
                <option value="Psychological Disability"
                    {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type ?? '') == 'Psychological Disability' ? 'selected' : '' }}>
                    5 - Psychological Disability
                </option>
                <option value="Chronic Illness"
                    {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type ?? '') == 'Chronic Illness' ? 'selected' : '' }}>
                    6 - Chronic Illness
                </option>
                <option value="Mental Disability"
                    {{ old('disability_type', $evaluation->speaker_evaluation_info->disability_type ?? '') == 'Mental Disability' ? 'selected' : '' }}>
                    7 - Mental Disability
                </option>
            </select>
            <div class="invalid-feedback">Please select civil disability</div>
        </div>


        <div class="col-sm-3">
            <label for="is_indigenous" class="form-label">Indigenous People (IP):</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_indigenous" id="IPYes" value="1"
                {{ old('is_indigenous', $evaluation->speaker_evaluation_info->is_indigenous ?? '') == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="IPYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_indigenous" id="IPNo" value="0"
                {{ old('is_indigenous', $evaluation->speaker_evaluation_info->is_indigenous ?? '') == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="IPNo">No</label>
            </div>
        </div>

        <!-- Tribe Name Input (Hidden by Default) -->
        <div class="col-sm-3" id="tribeContainer" >
            <label for="tribe_name" class="form-label">Name of Tribe</label>
            <input type="text" class="form-control" id="tribe_name" name="tribe_name" placeholder="Enter Tribe"
            value="{{ old('tribe_name', $evaluation->speaker_evaluation_info->tribe_name ?? '') }}" placeholder="Enter Tribe" {{ old('is_indigenous', $evaluation->speaker_evaluation_info->is_indigenous ?? '') == 0 ? 'disabled' : '' }}>
            <div class="invalid-feedback">Please enter Tribe</div>
        </div>
    </div>
</div>

<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-speaker-evaluation-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous
    </button>
    <button type="button" id="updateEvaluationProfile"
        class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-bill-finish"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
        Finish</button>
</div>
</div>
