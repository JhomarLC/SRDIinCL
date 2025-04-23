<div class="tab-pane fade" id="pills-other-info" role="tabpanel"
aria-labelledby="pills-other-info-tab">
<div>
    <h5>Overall Evaluation of the Training</h5>
    <p class="text-muted">Fill all information below</p>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6">
            <label class="form-label d-block mb-2">1. Achievement of the course objectives</label>
            <div class="form-check form-check-inline ">
                <input class="form-check-input" type="radio" name="goal_achievement" value="not_achieved">
                <label class="form-check-label">Not achieved</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="goal_achievement" value="partially_achieved" checked>
                <label class="form-check-label">Partially achieved</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="goal_achievement" value="achieved" checked>
                <label class="form-check-label">Achieved</label>
            </div>
        </div>
        <div class="col-sm-6">
            <label class="form-label d-block mb-2">2. Overall quality and satisfaction with the training</label>
            <div class="form-check form-check-inline ">
                <input class="form-check-input" type="radio" name="overall_quality" value="excellent">
                <label class="form-check-label">Excellent</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality"value="very_good" checked>
                <label class="form-check-label">Very Good</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality" value="good" checked>
                <label class="form-check-label">Good</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality" value="fair" checked>
                <label class="form-check-label">Fair</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality" value="poor" checked>
                <label class="form-check-label">Poor</label>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-12">
            <label for="recommend_training" class="form-label">1. List additional comments or
                suggestions on how future training programs can be improved or enhanced.</label>
            <textarea class="form-control" id="recommend_training" name="recommend_training" rows="3"></textarea>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3 align-items-center">
        <div class="col-sm-6">
            <label class="form-label d-block mb-2">
                2. Would you recommend this training or course to others you know?
            </label>
            <div class="row">
                <!-- Yes Radio -->
                <div class="col-auto">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommendation" id="recommendYes" value="yes">
                        <label class="form-check-label" for="recommendYes">Yes</label>
                    </div>
                </div>

                <!-- No Radio -->
                <div class="col-auto">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommendation" id="recommendNo" value="no">
                        <label class="form-check-label" for="recommendNo">No</label>
                    </div>
                </div>

                <!-- Reason Input -->
                <div class="col">
                    <input type="text" class="form-control" id="recommendReason"
                        placeholder="Enter your reason" required>
                    <div class="invalid-feedback">Please enter your reason</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <label for="recommend_training" class="form-label">3. What other training or course would you like PhilRice to conduct?</label>
            <input type="text" class="form-control" id="future_training_topics" placeholder="Enter training"></input>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <label for="recommend_training" class="form-label mb-2 mb-md-0">
                    Is there any PhilRice employee who left a good or bad impression on you? You may give a reason.
                </label>
                <button class="btn btn-secondary d-flex align-items-center">
                    <i class="ri-add-line me-1"></i> Add Employee
                </button>
            </div>
        </div>
        <div class="col-sm-6">
            <label for="recommend_training" class="form-label">Employee</label>
            <input type="text" class="form-control" id="future_training_topics" placeholder="Enter Employee"></input>
        </div>
        <div class="col-sm-6">
            <label for="recommend_training" class="form-label">Reason</label>
            <input type="text" class="form-control" id="future_training_topics" placeholder="Enter Reason"></input>
        </div>
    </div>
</div>



<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-trainings-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous</button>
    <button type="button"
        class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-data-ricefarming-tab"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
        Next</button>
</div>
</div>
<!-- end tab pane -->
