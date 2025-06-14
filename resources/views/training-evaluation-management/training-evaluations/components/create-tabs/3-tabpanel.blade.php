<div class="tab-pane fade" id="pills-overall-evaluation" role="tabpanel"
aria-labelledby="pills-overall-evaluation-tab">
<div>
    <h5>Overall Evaluation of the Training</h5>
    <p class="text-muted">Fill all information below</p>
</div>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-6">
            <label class="form-label d-block mb-2">1. Achievement of the course objectives <span class="text-danger">*</span></label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="goal_achievement" id="goal_achieved" value="Achieved">
                <label class="form-check-label" for="goal_achieved">Achieved</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="goal_achievement" id="goal_partially_achieved" value="Partially Achieved">
                <label class="form-check-label" for="goal_partially_achieved">Partially achieved</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="goal_achievement" id="goal_not_achieved" value="Not Achieved">
                <label class="form-check-label" for="goal_not_achieved">Not achieved</label>
            </div>
            <div class="invalid-feedback">Please enter a middle name</div>
        </div>

        <div class="col-sm-6">
            <label class="form-label d-block mb-2">2. Overall quality and satisfaction with the training <span class="text-danger">*</span></label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality" id="quality_excellent" value="Excellent">
                <label class="form-check-label" for="quality_excellent">Excellent</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality" id="quality_very_good" value="Very Good">
                <label class="form-check-label" for="quality_very_good">Very Good</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality" id="quality_good" value="Good">
                <label class="form-check-label" for="quality_good">Good</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality" id="quality_fair" value="Fair">
                <label class="form-check-label" for="quality_fair">Fair</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="overall_quality" id="quality_poor" value="Poor">
                <label class="form-check-label" for="quality_poor">Poor</label>
            </div>
            <div class="invalid-feedback">Please enter a middle name</div>
        </div>

    </div>
</div>
<hr>
<div class="mt-3">
    <div class="row g-3">
        <div class="col-sm-12">
            <label for="additional_feedback_or_suggestions" class="form-label">List additional comments or
                suggestions on how future training programs can be improved or enhanced.</label>
            <textarea class="form-control" id="additional_feedback_or_suggestions" name="additional_feedback_or_suggestions" rows="3"></textarea>
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
                        <input class="form-check-input" type="radio" name="recommend_training" id="recommendYes" value="1">
                        <label class="form-check-label" for="recommendYes">Yes</label>
                    </div>
                </div>

                <!-- No Radio -->
                <div class="col-auto">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommend_training" id="recommendNo" value="0" checked>
                        <label class="form-check-label" for="recommendNo">No</label>
                    </div>
                </div>

                <!-- Reason Input -->
                <div class="col">
                    <input type="text" class="form-control" id="recommendation_reason" name="recommendation_reason"
                        placeholder="Enter your reason" disabled>
                </div>

                <div class="invalid-feedback">Please enter your reason</div>
            </div>
        </div>
        <div class="col-sm-6">
            <label for="recommend_training" class="form-label">3. What other training or course would you like PhilRice to conduct?</label>
            <input type="text" class="form-control" id="preferred_future_trainings" name="preferred_future_trainings" placeholder="Enter training"></input>
        </div>
    </div>
</div>
<div id="employeeContainer" class="mt-3">
    <div class="d-flex align-items-center">
        <label class="flex-grow-1 form-label mb-2 mb-md-0">
            Is there any PhilRice employee who left a good or bad impression on you? You may give a reason.
        </label>
        <button type="button" id="addTrainingBtn" class="btn btn-sm btn-secondary add-employee">
            <i class="ri-add-line"></i> Add Employee
        </button>
    </div>
    <div class="employee-entry mt-3">
        <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label">Employee Name</label>
                <input type="text" class="form-control" id="employee_name" name="employee_name[]" placeholder="Enter Employee">
            </div>
            <div class="col-sm-6">
                <label class="form-label">Reason</label>
                <input type="text" class="form-control" id="employee_reason" name="employee_reason[]" placeholder="Enter Reason">
            </div>
            <div class="col-sm-12 d-flex gap-2">
                <button type="button" class="btn btn-sm btn-warning clear-employee">Clear Fields</button>
                <button type="button" class="btn btn-sm btn-danger remove-employee d-none">Remove</button>
            </div>
        </div>
        <hr>
    </div>
</div>

<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-course-management-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous</button>
    <button type="button"
        class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-personal-info-tab"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
        Next</button>
</div>
</div>
<!-- end tab pane -->
