<div class="tab-pane fade" id="pills-personal-info" role="tabpanel"
aria-labelledby="pills-personal-info-tab">
<div>

    <h5>Personal Information</h5>
    <p class="text-muted">Fill all information below</p>
</div>
@php
    $participantInfo = $evaluation->training_participant_info ?? null;
@endphp

<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-3">
            <label for="first_name" class="form-label">First name</label>
            <input type="text" class="form-control" id="first_name" name="first_name"
                value="{{ old('first_name', $participantInfo->first_name) }}"
                placeholder="Enter first name">
            <div class="invalid-feedback">Please enter a first name</div>
        </div>

        <div class="col-sm-3">
            <label for="middle_name" class="form-label">Middle name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name"
                value="{{ old('middle_name', $participantInfo->middle_name) }}"
                placeholder="Enter middle name">
            <div class="invalid-feedback">Please enter a middle name</div>
        </div>

        <div class="col-sm-3">
            <label for="last_name" class="form-label">Last name</label>
            <input type="text" class="form-control" id="last_name" name="last_name"
                value="{{ old('last_name', $participantInfo->last_name) }}"
                placeholder="Enter last name">
            <div class="invalid-feedback">Please enter a last name</div>
        </div>
        <div class="col-sm-3">
            <label for="suffix" class="form-label">Suffix</label>
            <input type="text" class="form-control" id="suffix" name="suffix"
                value="{{ old('suffix', $participantInfo->suffix) }}"
                placeholder="Enter Suffix">
            <div class="invalid-feedback">Please enter Suffix</div>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
            <select class="form-control mb-3 select2" id="sex" name="sex">
                <option selected disabled hidden>-- SELECT SEX --</option>
                <option value="Male" {{ $participantInfo->sex === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $participantInfo->sex === 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            <div class="invalid-feedback">Please select sex</div>
        </div>
        <div class="col-sm-6" >
            <label for="update_province" class="form-label">Province <span class="text-danger">*</span></label>
            <select class="form-control select2" id="update_province" name="province_code" aria-label="Default select example">
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
                    <input class="form-check-input" type="radio" name="age_group" id="below18" value="below 18"
                    {{ $participantInfo->age_group === 'below 18' ? 'checked' : '' }}>
                    <label class="form-check-label" for="below18">below 18</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="18to30" value="18-30"
                    {{ $participantInfo->age_group === '18-30' ? 'checked' : '' }}>
                    <label class="form-check-label" for="18to30">18-30</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="31to45" value="31-45"
                    {{ $participantInfo->age_group === '31-45' ? 'checked' : '' }}>
                    <label class="form-check-label" for="31to45">31-45</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="46to59" value="46-59"
                    {{ $participantInfo->age_group === '46-59' ? 'checked' : '' }}>
                    <label class="form-check-label" for="46to59">46-59</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="age_group" id="60above" value="60 and above"
                    {{ $participantInfo->age_group === '60 and above' ? 'checked' : '' }}>
                    <label class="form-check-label" for="60above">60 and Above</label>
                </div>
            </div>
            <div class="invalid-feedback">Please select age group</div>
        </div>
        <div class="col-sm-6" >
            <label for="primary_sector" class="form-label">Primary sector involved in <span class="text-danger">*</span></label>
            <select class="form-control select2" id="primary_sector" name="primary_sector" aria-label="Default select example">
                <option selected disabled hidden>-- SELECT PRIMARY SECTOR --</option>
                <option value="Farmer/Seed Grower" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Farmer/Seed Grower' ? 'selected' : '' }}>Farmer or Seed grower</option>
                <option value="Extension Worker" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Extension Worker' ? 'selected' : '' }}>Extension workers and other intermediaries (e.g. LFT, trainer, extension worker)</option>
                <option value="Researcher" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Researcher' ? 'selected' : '' }}>Researcher</option>
                <option value="Educator" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Educator' ? 'selected' : '' }}>Educator (elementary/high school/college teachers)</option>
                <option value="Student" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Student' ? 'selected' : '' }}>Student (e.g. college student, post-graduate student)</option>
                <option value="Policy Maker" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Policy Maker' ? 'selected' : '' }}>Policy maker (e.g. local chief executive)</option>
                <option value="Media" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Media' ? 'selected' : '' }}>Media (e.g. broadcaster, vlogger, etc)</option>
                <option value="Industry Player" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Industry Player' ? 'selected' : '' }}>Industry Player (e.g. trader, miller, wholesaler, retailer)</option>
                <option value="Others" {{ old('primary_sector', $participantInfo->primary_sector ?? '') == 'Others' ? 'selected' : '' }}>Other (e.g. OFW, job seeker, freelancer, consultant)</option>
            </select>
            <div class="invalid-feedback">Please select civil primary sector</div>
        </div>
    </div>
</div>



<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-overall-evaluation-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous</button>
    <button type="button" id="submitTrainingEvaluation"
        class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-bill-finish"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
        Finish</button>
</div>
</div>
