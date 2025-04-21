

<div class="tab-pane fade" id="pills-training-result" role="tabpanel"
aria-labelledby="pills-training-result-tab">
<div>

    <h5>Training Results</h5>
    <p class="text-muted">Fill all information below</p>
</div>

<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-7">
            <label for="training_title_main" class="form-label">Title of the training/workshop <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="training_title_main" name="training_title_main" value="Training on Pests and Nutrient Management (PNM)"
                placeholder="Training on Pests and Nutrient Management (PNM)" disabled >
            <div class="invalid-feedback">Please enter training title</div>
        </div>
        <div class="col-sm-5">
            <label for="training_date_main" class="form-label">Training Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="training_date_main" name="training_date_main">
            <div class="invalid-feedback">Please select year conducted</div>
        </div>
        {{-- <div class="col-sm-12">
            <label for="training_location_main" class="form-label">Training Location</label>
            <input type="text" class="form-control" id="training_location_main" name="training_location_main"
                placeholder="Enter training location">
            <div class="invalid-feedback">Please enter training location</div>
        </div> --}}
        <div class="mt-3">
            <div class="row g-3">
                <div class="col-sm-4" >
                    <label for="civilStatus" class="form-label">Province <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="ts_province" name="ts_province_code" aria-label="Default select example">
                        <option selected disabled hidden>-- SELECT PROVINCE --</option>
                    </select>
                    <div class="invalid-feedback">Please select province</div>
                </div>
                <div class="col-sm-4" >
                    <label for="civilStatus" class="form-label">Municipality <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="ts_municipality" name="ts_municipality_code" aria-label="Default select example" disabled>
                        <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                    </select>
                    <div class="invalid-feedback">Please select civil municipality</div>
                </div>
                <div class="col-sm-4" >
                    <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="ts_barangay" name="ts_barangay_code" aria-label="Default select example" disabled>
                        <option selected disabled hidden>-- SELECT BARANGAY --</option>
                    </select>
                    <div class="invalid-feedback">Please select civil barangay</div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <label for="total_test_items" class="form-label">Total no. of Test items <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="total_test_items" name="total_test_items" value="100"
                placeholder="Enter number of test items">
            <div class="invalid-feedback">Please enter number of test items</div>
        </div>
        <div class="col-sm-3">
            <label for="pre_test_score" class="form-label">Pre-Test (Written)</label>
            <input type="number" class="form-control" id="pre_test_score" name="pre_test_score" value="40"
                placeholder="Enter Pre-Test">
            <div class="invalid-feedback">Please enter pre-test</div>
        </div>
        <div class="col-sm-3">
            <label for="post_test_score" class="form-label">Post-Test (Written)</label>
            <input type="number" class="form-control" id="post_test_score" name="post_test_score" value="60"
                placeholder="Enter Post-Test">
            <div class="invalid-feedback">Please enter post test</div>
        </div>
        <div class="col-sm-3">
            <label for="gain_in_knowledge_display" class="form-label">Gain in Knowledge</label>
            <input type="text" id="gain_in_knowledge" name="gain_in_knowledge" value="33.33" hidden>
            <input type="text" class="form-control" id="gain_in_knowledge_display" name="gain_in_knowledge_display" value="33.33 %" disabled
                placeholder="0.00%">
            {{-- <div class="invalid-feedback">Calculated Gain in Knowledge</div> --}}
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-2">
            <label for="total_no_meetings" class="form-label">Total No. of Meetings</label>
            <input type="number" class="form-control" id="total_no_meetings" name="total_no_meetings" value="5"
                placeholder="Enter Total No. of Meetings">
            <div class="invalid-feedback">Please enter total no. of meetings</div>
        </div>
        <div class="col-sm-2">
            <label for="meetings_attended" class="form-label">No. of Meetings Attended</label>
            <input type="number" class="form-control" id="meetings_attended" name="meetings_attended" value="4"
                placeholder="Enter No. of Meetings Attended">
            <div class="invalid-feedback">Please enter no. of meetings attended</div>
        </div>
        <div class="col-sm-2">
            <label for="percentage_meetings_attended" class="form-label">% of Meetings Attended</label>
            <input type="number" class="form-control" id="percentage_meetings_attended" name="percentage_meetings_attended" disabled
                placeholder="Percentage of Meetings Attended">
            <div class="invalid-feedback">Please enter no. of meetings attended</div>
        </div>
        <div class="col-sm-3">
            <label for="certificate_type" class="form-label">Type of Certificate</label>
            <input type="text" class="form-control" id="certificate_type" name="certificate_type" disabled
                placeholder="Type of Certificate">
            <div class="invalid-feedback">Please enter Type of Certificate</div>
        </div>
        {{-- <div class="col-sm-3">
            <label for="certificate_type" class="form-label">Type of Certificate</label>
            <input type="text" class="form-control" id="certificate_type" name="certificate_type" value="Digital"
                placeholder="Enter type of certificate">
            <div class="invalid-feedback">Please enter type of certificate</div>
        </div> --}}
        <div class="col-sm-3">
            <label for="certificate_number" class="form-label">Certificate number</label>
            <input type="text" class="form-control" id="certificate_number" name="certificate_number" value="1029384"
                placeholder="Enter Certificate Number">
            <div class="invalid-feedback">Please enter certificate number</div>
        </div>
    </div>
</div>
{{-- <div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="overall_training_eval_score" class="form-label">Overall Training Evaluation</label>
            <input type="number" class="form-control" id="overall_training_eval_score" name="overall_training_eval_score"
                placeholder="Enter Overall Training Evaluation">
            <div class="invalid-feedback">Please enter overall training evaluation</div>
        </div>
        <div class="col-sm-6">
            <label for="trainer_rating" class="form-label">TMT Rating in Training Evaluation</label>
            <input type="number" class="form-control" id="trainer_rating" name="trainer_rating"
                placeholder="Enter TMT Rating in Training Evaluation">
            <div class="invalid-feedback">Please enter TMT Rating in Training Evaluation</div>
        </div>
    </div>
</div> --}}

<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-emergency-contact-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous</button>
    <button type="button" id="submitFarmersProfile"
        class="btn btn-success btn-label right ms-auto nexttab nexttab"
        data-nexttab="pills-bill-finish"><i
            class="ri-save-line label-icon align-middle fs-16 ms-2"></i>
        Submit</button>
</div>
</div>
<!-- end tab pane -->
