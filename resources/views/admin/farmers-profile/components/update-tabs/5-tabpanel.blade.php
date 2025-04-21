<div class="tab-pane fade" id="pills-emergency-contact" role="tabpanel"
aria-labelledby="pills-emergency-contact-tab">
<div>
    <h5>Emergency Contact</h5>
    <p class="text-muted">Fill all information below</p>
</div>

<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-3">
            <label for="ec_first_name" class="form-label">First name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="ec_first_name" name="ec_first_name"
                value="{{ old('ec_first_name', $participant->emergency_contact->first_name ?? '') }}"
                placeholder="Enter first name" >
            <div class="invalid-feedback">Please enter a first name</div>
        </div>

        <div class="col-sm-3">
            <label for="ec_middle_name" class="form-label">Middle name</label>
            <input type="text" class="form-control" id="ec_middle_name" name="ec_middle_name"
                value="{{ old('ec_middle_name', $participant->emergency_contact->middle_name ?? '') }}"
                placeholder="Enter middle name" >
            <div class="invalid-feedback">Please enter a middle name</div>
        </div>

        <div class="col-sm-3">
            <label for="ec_last_name" class="form-label">Last name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="ec_last_name" name="ec_last_name"
                value="{{ old('ec_last_name', $participant->emergency_contact->last_name ?? '') }}"
                placeholder="Enter last name" >
            <div class="invalid-feedback">Please enter a last name</div>
        </div>
        <div class="col-sm-3">
            <label for="ec_suffix" class="form-label">Suffix</label>
            <input type="text" class="form-control" id="ec_suffix" name="ec_suffix"
                value="{{ old('ec_suffix', $participant->emergency_contact->suffix ?? '') }}"
                placeholder="Enter Suffix" >
            <div class="invalid-feedback">Please enter Suffix</div>
        </div>
    </div>
</div>

<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="ec_relationship" class="form-label">Relationship <span class="text-danger">*</span></label>
            <select class="form-control mb-3 select2" id="ec_relationship" name="ec_relationship" aria-label="Select emergency contact relationship">
                <option selected disabled hidden>-- SELECT RELATIONSHIP --</option>
                <optgroup label="Family">
                    <option value="Spouse" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                    <option value="Parent" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Parent' ? 'selected' : '' }}>Parent</option>
                    <option value="Child" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Child' ? 'selected' : '' }}>Child</option>
                    <option value="Sibling" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                    <option value="Grandparent" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Grandparent' ? 'selected' : '' }}>Grandparent</option>
                    <option value="Grandchild" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Grandchild' ? 'selected' : '' }}>Grandchild</option>
                    <option value="Aunt_uncle" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Aunt_uncle' ? 'selected' : '' }}>Aunt / Uncle</option>
                    <option value="Cousin" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                    <option value="Niece_nephew" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Niece_nephew' ? 'selected' : '' }}>Niece / Nephew</option>
                    <option value="In_law" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'In_law' ? 'selected' : '' }}>In-law</option>
                </optgroup>

                <optgroup label="Non-Family">
                    <option value="Friend" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Friend' ? 'selected' : '' }}>Friend</option>
                    <option value="Partner" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Partner' ? 'selected' : '' }}>Partner</option>
                    <option value="Roommate" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Roommate' ? 'selected' : '' }}>Roommate</option>
                    <option value="Neighbor" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Neighbor' ? 'selected' : '' }}>Neighbor</option>
                    <option value="Coworker" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Coworker' ? 'selected' : '' }}>Coworker</option>
                    <option value="Supervisor" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                </optgroup>

                <optgroup label="Other / Legal">
                    <option value="Legal_guardian" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Legal_guardian' ? 'selected' : '' }}>Legal Guardian</option>
                    <option value="Caregiver" {{ old('ec_relationship', $participant->emergency_contact->relationship ?? '') == 'Caregiver' ? 'selected' : '' }}>Caregiver</option>
                </optgroup>
            </select>
            <div class="invalid-feedback">Please enter relationship</div>
        </div>
        <div class="col-sm-6">
            <label for="ec_contact_number" class="form-label">Telephone / Phone Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="ec_contact_number" name="ec_contact_number"
                value="{{ old('ec_contact_number', $participant->emergency_contact->contact_number ?? '') }}"
                placeholder="Enter phone number" >
            <div class="invalid-feedback">Please enter phone number</div>
        </div>
    </div>
</div>

<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-data-ricefarming-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous</button>
    <button type="button"
        class="btn btn-success btn-label right ms-auto nexttab nexttab"
        data-nexttab="pills-training-result-tab"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
        Next</button>
</div>
</div>
