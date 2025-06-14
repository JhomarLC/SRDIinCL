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
            <input type="text" class="form-control" id="ec_first_name" name="ec_first_name" value="Marilyn"
                placeholder="Enter first name" >
            <div class="invalid-feedback">Please enter a first name</div>
        </div>

        <div class="col-sm-3">
            <label for="ec_middle_name" class="form-label">Middle name</label>
            <input type="text" class="form-control" id="ec_middle_name" name="ec_middle_name" value="Lapurga"
                placeholder="Enter middle name" >
            <div class="invalid-feedback">Please enter a middle name</div>
        </div>

        <div class="col-sm-3">
            <label for="ec_last_name" class="form-label">Last name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="ec_last_name" name="ec_last_name" value="Candelario"
                placeholder="Enter last name" >
            <div class="invalid-feedback">Please enter a last name</div>
        </div>
        <div class="col-sm-3">
            <label for="ec_suffix" class="form-label">Suffix</label>
            <input type="text" class="form-control" id="ec_suffix" name="ec_suffix"
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
                    <option value="Spouse">Spouse</option>
                    <option value="Parent" selected>Parent</option>
                    <option value="Child">Child</option>
                    <option value="Sibling">Sibling</option>
                    <option value="Grandparent">Grandparent</option>
                    <option value="Grandchild">Grandchild</option>
                    <option value="Aunt_uncle">Aunt / Uncle</option>
                    <option value="Cousin">Cousin</option>
                    <option value="Niece_nephew">Niece / Nephew</option>
                    <option value="In_law">In-law</option>
                </optgroup>

                <optgroup label="Non-Family">
                    <option value="Friend">Friend</option>
                    <option value="Partner">Partner</option>
                    <option value="Roommate">Roommate</option>
                    <option value="Neighbor">Neighbor</option>
                    <option value="Coworker">Coworker</option>
                    <option value="Supervisor">Supervisor</option>
                </optgroup>

                <optgroup label="Other / Legal">
                    <option value="Legal_guardian">Legal Guardian</option>
                    <option value="Caregiver">Caregiver</option>
                </optgroup>
            </select>
            <div class="invalid-feedback">Please enter relationship</div>
        </div>
        <div class="col-sm-6">
            <label for="ec_contact_number" class="form-label">Telephone / Phone Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="ec_contact_number" name="ec_contact_number" value="09366181790"
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
