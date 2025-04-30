<div class="tab-pane fade" id="pills-course-management" role="tabpanel"
aria-labelledby="pills-course-management-tab">
<div class="d-flex align-items-center">
        <h5 class="flex-grow-1">Course Management</h5>
</div>

<p class="text-muted">Fill all information below</p>
<div class="mt-4">
    {{-- <h5>Speaker Evaluation</h5> --}}
    <p class="text-muted">Please rate the speaker or resource person using a scale of 1 to 5,
        where <strong>1 is the lowest</strong> and <strong>5 is the highest</strong>.
    </p>
</div>

<div class="table-responsive mt-4">
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>Criteria</th>
                <th>5<br>(Excellent)</th>
                <th>4<br>(Very Good)</th>
                <th>3<br>(Good)</th>
                <th>2<br>(Fair)</th>
                <th>1<br>(Poor)</th>
                <th>Reason for the given rating</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Coordination regarding the training</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="coordination_comment" name="coordination_comment"></textarea></td>
            </tr>
            <tr>
                <td>Time management</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="time_management_comment" name="time_management_comment"></textarea></td>
            </tr>
            <tr>
                <td>Resource persons (speakers)</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="speaker_quality_comment" name="speaker_quality_comment"></textarea></td>
            </tr>
            <tr>
                <td>Facilitators</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="facilitators_comment" name="facilitators_comment"></textarea></td>
            </tr>
            <tr>
                <td>Training support staff</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="support_staff_comment" name="support_staff_comment"></textarea></td>
            </tr>
            <tr>
                <td>Materials provided for the training (videos, presentation, etc.)</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="materials_comment" name="materials_comment"></textarea></td>
            </tr>
            <tr>
                <td>Venue and facilities for the training</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="facility_comment" name="facility_comment"></textarea></td>
            </tr>
            <tr>
                <td>Lodging/sleeping accommodations</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="accommodation_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="accommodation_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="accommodation_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="accommodation_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="accommodation_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="accommodation_comment" name="accommodation_comment"></textarea></td>
            </tr>
            <tr>
                <td>Food and service</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="food_quality_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="food_quality_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="food_quality_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="food_quality_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="food_quality_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="food_quality_comment" name="food_quality_comment"></textarea></td>
            </tr>
            <tr>
                <td>Transportation and travel arrangements</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="transportation_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="transportation_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="transportation_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="transportation_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="transportation_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="transportation_comment" name="transportation_comment"></textarea></td>
            </tr>
            <tr>
                <td>Overall quality of the training</td>
                <td class="text-center"><input class="form-check-input" type="radio" name="overall_management_score" value="5"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="overall_management_score" value="4"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="overall_management_score" value="3"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="overall_management_score" value="2"></td>
                <td class="text-center"><input class="form-check-input" type="radio" name="overall_management_score" value="1"></td>
                <td><textarea type="text" class="form-control" id="overall_management_comment" name="overall_management_comment"></textarea></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="mt-3">
    <label for="low_score_comment_2" class="form-label">Reason or comment for any rating lower than 3 (Good):</label>
    <textarea class="form-control" id="low_score_comment_2" name="low_score_comment_2" rows="3"></textarea>
</div>

<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab"
        data-previous="pills-training-content-tab"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
        Previous</button>
    <button type="button"
        class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-overall-evaluation-tab"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
</div>
</div>
<!-- end tab pane -->
