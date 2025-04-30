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
            @php
                $courseManagementEval = $evaluation->course_management_evaluation ?? null;
            @endphp

            <tr>
                <td>Coordination regarding the training</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="coordination_score" value="{{ $i }}"
                        {{ (old('coordination_score', $courseManagementEval->coordination_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="coordination_comment">{{ old('coordination_comment', $courseManagementEval->coordination_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Time management</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="time_management_score" value="{{ $i }}"
                        {{ (old('time_management_score', $courseManagementEval->time_management_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="time_management_comment">{{ old('time_management_comment', $courseManagementEval->time_management_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Resource persons (speakers)</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="speaker_quality_score" value="{{ $i }}"
                        {{ (old('speaker_quality_score', $courseManagementEval->speaker_quality_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="speaker_quality_comment">{{ old('speaker_quality_comment', $courseManagementEval->speaker_quality_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Facilitators</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="facilitators_score" value="{{ $i }}"
                        {{ (old('facilitators_score', $courseManagementEval->facilitators_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="facilitators_comment">{{ old('facilitators_comment', $courseManagementEval->facilitators_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Training support staff</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="support_staff_score" value="{{ $i }}"
                            {{ (old('support_staff_score', $courseManagementEval->support_staff_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="support_staff_comment">{{ old('support_staff_comment', $courseManagementEval->support_staff_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Materials provided for the training (videos, presentation, etc.)</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="materials_score" value="{{ $i }}"
                            {{ (old('materials_score', $courseManagementEval->materials_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="materials_comment">{{ old('materials_comment', $courseManagementEval->materials_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Venue and facilities for the training</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="facility_score" value="{{ $i }}"
                            {{ (old('facility_score', $courseManagementEval->facility_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="facility_comment">{{ old('facility_comment', $courseManagementEval->facility_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Lodging/sleeping accommodations</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="accommodation_score" value="{{ $i }}"
                            {{ (old('accommodation_score', $courseManagementEval->accommodation_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="accommodation_comment">{{ old('accommodation_comment', $courseManagementEval->accommodation_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Food and service</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="food_quality_score" value="{{ $i }}"
                            {{ (old('food_quality_score', $courseManagementEval->food_quality_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="food_quality_comment">{{ old('food_quality_comment', $courseManagementEval->food_quality_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Transportation and travel arrangements</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="transportation_score" value="{{ $i }}"
                            {{ (old('transportation_score', $courseManagementEval->transportation_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="transportation_comment">{{ old('transportation_comment', $courseManagementEval->transportation_comment ?? '') }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Overall quality of the training</td>
                @for ($i = 5; $i >= 1; $i--)
                    <td class="text-center">
                        <input class="form-check-input" type="radio" name="overall_management_score" value="{{ $i }}"
                            {{ (old('overall_management_score', $courseManagementEval->overall_management_score ?? '') == $i) ? 'checked' : '' }}>
                    </td>
                @endfor
                <td>
                    <textarea class="form-control" name="overall_management_comment">{{ old('overall_management_comment', $courseManagementEval->overall_management_comment ?? '') }}</textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="mt-3">
    <label for="low_score_comment" class="form-label">Reason or comment for any rating lower than 3 (Good):</label>
    <textarea class="form-control" id="low_score_comment_2" name="low_score_comment_2" rows="3">{{ old('low_score_comment_2', $courseManagementEval->low_score_comment_2 ?? '') }}</textarea>
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
