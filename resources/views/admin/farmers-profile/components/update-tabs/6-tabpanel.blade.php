<div class="tab-pane fade" id="pills-training-result" role="tabpanel" aria-labelledby="pills-training-result-tab">
    <div>
        <h5>Training Results</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div id="trainingContainer">
        @php
            $trainingResult = $participant->training_results;  // Get the first (and only) training result
        @endphp

        @if ($trainingResult)
        <div class="training-entry position-relative border p-3 mb-4">
            <div class="mt-3">
                <div class="row g-3">
                    <div class="col-sm-7">
                        <label for="training_title_main" class="form-label">Title of the training/workshop</label>
                        <input type="text" class="form-control" id="training_title_main" name="training_title_main" value="Training on Pests and Nutrient Management (PNM)"
                            placeholder="Training on Pests and Nutrient Management (PNM)" disabled >
                        <div class="invalid-feedback">Please enter training title</div>
                    </div>
                    <div class="col-sm-5">
                        <label for="training_date_main" class="form-label">Training Date</label>
                        <input type="date" class="form-control" id="training_date_main" name="training_date_main"
                            value="{{ old('training_date_main',$trainingResult->training_date_main) }}">
                        <div class="invalid-feedback">Please select year conducted</div>
                    </div>
                    <div class="col-sm-12">
                        <label for="training_location_main" class="form-label">Training Location</label>
                        <input type="text" class="form-control" id="training_location_main" name="training_location_main"
                            value="{{ old('training_location_main', $trainingResult->training_location_main ?? '') }}"
                            placeholder="Enter training location">
                        <div class="invalid-feedback">Please enter training location</div>
                    </div>
                    <div class="col-sm-4">
                        <label for="pre_test_score" class="form-label">Pre-Test (Written)</label>
                        <input type="number" class="form-control" id="pre_test_score" name="pre_test_score"
                               value="{{ old('pre_test_score', $trainingResult->pre_test_score ?? '') }}"
                               placeholder="Enter Pre-Test">
                        <div class="invalid-feedback">Please enter pre-test</div>
                    </div>
                    <div class="col-sm-4">
                        <label for="post_test_score" class="form-label">Post-Test (Written)</label>
                        <input type="number" class="form-control" id="post_test_score" name="post_test_score"
                               value="{{ old('post_test_score', $trainingResult->post_test_score ?? '') }}"
                               placeholder="Enter Post-Test">
                        <div class="invalid-feedback">Please enter post test</div>
                    </div>
                    <div class="col-sm-4">
                        <label for="total_test_items" class="form-label">Total no. of Test items</label>
                        <input type="number" class="form-control" id="total_test_items" name="total_test_items"
                               value="{{ old('total_test_items', $trainingResult->total_test_items ?? '') }}"
                               placeholder="Enter number of test items">
                        <div class="invalid-feedback">Please enter number of test items</div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="row g-3">
                    <div class="col-sm-4">
                        <label for="gain_in_knowledge_display" class="form-label">Gain in Knowledge</label>
                        <input type="text" id="gain_in_knowledge" name="gain_in_knowledge" value="{{ old('gain_in_knowledge', $trainingResult->gain_in_knowledge ?? '0') }}" hidden>
                        <input type="text" class="form-control" id="gain_in_knowledge_display" name="gain_in_knowledge_display"
                               value="{{ old('gain_in_knowledge_display', number_format($trainingResult->gain_in_knowledge ?? 0, 2) . ' %') }}" disabled
                               placeholder="0.00%">
                    </div>
                    <div class="col-sm-4">
                        <label for="certificate_type" class="form-label">Type of Certificate</label>
                        <input type="text" class="form-control" id="certificate_type" name="certificate_type"
                               value="{{ old('certificate_type', $trainingResult->certificate_type ?? '') }}"
                               placeholder="Enter type of certificate">
                        <div class="invalid-feedback">Please enter type of certificate</div>
                    </div>
                    <div class="col-sm-4">
                        <label for="certificate_number" class="form-label">Certificate number</label>
                        <input type="text" class="form-control" id="certificate_number" name="certificate_number"
                               value="{{ old('certificate_number', $trainingResult->certificate_number ?? '') }}"
                               placeholder="Enter Certificate Number">
                        <div class="invalid-feedback">Please enter certificate number</div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="overall_training_eval_score" class="form-label">Overall Training Evaluation</label>
                        <input type="number" class="form-control" id="overall_training_eval_score" name="overall_training_eval_score"
                               value="{{ old('overall_training_eval_score', $trainingResult->overall_training_eval_score ?? '') }}"
                               placeholder="Enter Overall Training Evaluation">
                        <div class="invalid-feedback">Please enter overall training evaluation</div>
                    </div>
                    <div class="col-sm-6">
                        <label for="trainer_rating" class="form-label">TMT Rating in Training Evaluation</label>
                        <input type="number" class="form-control" id="trainer_rating" name="trainer_rating"
                               value="{{ old('trainer_rating', $trainingResult->trainer_rating ?? '') }}"
                               placeholder="Enter TMT Rating in Training Evaluation">
                        <div class="invalid-feedback">Please enter TMT Rating in Training Evaluation</div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <p>No training results available.</p>
        @endif
    </div>

    <hr>

    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label previestab"
            data-previous="pills-emergency-contact-tab"><i
                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
            Previous
        </button>
        <button type="button" id="updateFarmersProfile"
            class="btn btn-success btn-label right ms-auto nexttab nexttab"
            data-nexttab="pills-bill-finish"><i
                class="ri-save-line label-icon align-middle fs-16 ms-2"></i>
            Submit
        </button>
    </div>
</div>
<!-- end tab pane -->
