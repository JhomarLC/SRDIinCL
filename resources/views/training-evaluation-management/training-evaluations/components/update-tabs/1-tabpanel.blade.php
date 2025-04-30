<div class="tab-pane fade show active" id="pills-training-content" role="tabpanel"
aria-labelledby="pills-training-content-tab">
<div>
    <div>
        <h5>Training Content</h5>
        <p class="text-muted">Fill all information below</p>
    </div>
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
                    $trainingContent = $evaluation->training_content_evaluation ?? null;
                @endphp

                {{-- Training objectives --}}
                <tr>
                    <td>Training objectives</td>
                    @for ($i = 5; $i >= 1; $i--)
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="objective_score" value="{{ $i }}"
                            {{ (old('objective_score', $trainingContent->objective_score ?? '') == $i) ? 'checked' : '' }}>
                        </td>
                    @endfor
                    <td><textarea class="form-control" name="objective_comment">{{ old('objective_comment', $trainingContent->objective_comment ?? '') }}</textarea></td>
                </tr>

                {{-- Relevance --}}
                <tr>
                    <td>Relevance of the training or course to your work/duties</td>
                    @for ($i = 5; $i >= 1; $i--)
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="relevance_score" value="{{ $i }}"
                            {{ (old('relevance_score', $trainingContent->relevance_score ?? '') == $i) ? 'checked' : '' }}>
                        </td>
                    @endfor
                    <td><textarea class="form-control" name="relevance_comment">{{ old('relevance_comment', $trainingContent->relevance_comment ?? '') }}</textarea></td>
                </tr>

                {{-- Content completeness --}}
                <tr>
                    <td>Content of the training</td>
                    @for ($i = 5; $i >= 1; $i--)
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="content_completeness_score" value="{{ $i }}"
                            {{ (old('content_completeness_score', $trainingContent->content_completeness_score ?? '') == $i) ? 'checked' : '' }}>
                        </td>
                    @endfor
                    <td><textarea class="form-control" name="content_completeness_comment">{{ old('content_completeness_comment', $trainingContent->content_completeness_comment ?? '') }}</textarea></td>
                </tr>

                {{-- Lecture and hands-on --}}
                <tr>
                    <td>Sufficient combination of lecture and hands-on</td>
                    @for ($i = 5; $i >= 1; $i--)
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="lecture_hands_on_score" value="{{ $i }}"
                            {{ (old('lecture_hands_on_score', $trainingContent->lecture_hands_on_score ?? '') == $i) ? 'checked' : '' }}>
                        </td>
                    @endfor
                    <td><textarea class="form-control" name="lecture_hands_on_comment">{{ old('lecture_hands_on_comment', $trainingContent->lecture_hands_on_comment ?? '') }}</textarea></td>
                </tr>

                {{-- Sequence --}}
                <tr>
                    <td>Sequence or arrangement of topics</td>
                    @for ($i = 5; $i >= 1; $i--)
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="sequence_score" value="{{ $i }}"
                            {{ (old('sequence_score', $trainingContent->sequence_score ?? '') == $i) ? 'checked' : '' }}>
                        </td>
                    @endfor
                    <td><textarea class="form-control" name="sequence_comment">{{ old('sequence_comment', $trainingContent->sequence_comment ?? '') }}</textarea></td>
                </tr>

                {{-- Duration --}}
                <tr>
                    <td>Duration of the training</td>
                    @for ($i = 5; $i >= 1; $i--)
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="duration_score" value="{{ $i }}"
                            {{ (old('duration_score', $trainingContent->duration_score ?? '') == $i) ? 'checked' : '' }}>
                        </td>
                    @endfor
                    <td><textarea class="form-control" name="duration_comment">{{ old('duration_comment', $trainingContent->duration_comment ?? '') }}</textarea></td>
                </tr>

                {{-- Assessment method --}}
                <tr>
                    <td>Method of examination</td>
                    @for ($i = 5; $i >= 1; $i--)
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="assessment_method_score" value="{{ $i }}"
                            {{ (old('assessment_method_score', $trainingContent->assessment_method_score ?? '') == $i) ? 'checked' : '' }}>
                        </td>
                    @endfor
                    <td><textarea class="form-control" name="assessment_method_comment">{{ old('assessment_method_comment', $trainingContent->assessment_method_comment ?? '') }}</textarea></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <label for="low_score_comment" class="form-label">Reason or comment for any rating lower than 3 (Good):</label>
        <textarea class="form-control" id="low_score_comment_1" name="low_score_comment_1" rows="3">{{ old('low_score_comment_1', $trainingContent->low_score_comment_1 ?? '') }}</textarea>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-12">
                <label for="gender" class="form-label">List 3 topics that you think would be helpful in your current work/duties</label>
                <select class="form-control" id="choices-multiple-remove-button" name="three_topics[]"
                data-choices data-choices-limit="3" data-choices-removeItem multiple>
                <option selected disabled hidden>-- SELECT TOPIC DISCUSSED --</option>

                <optgroup label="A. Overview of the PalayCheck System">
                    <option value="Overview of the PalayCheck System"
                        {{ in_array('Overview of the PalayCheck System', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        1. Overview of the PalayCheck System
                    </option>
                </optgroup>

                <optgroup label="C. Integrated Pest Management">
                    <option value="IPM concepts and principles"
                        {{ in_array('IPM concepts and principles', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        1. IPM concepts and principles
                    </option>
                    <option value="Insect Pests and Natural Enemies"
                        {{ in_array('Insect Pests and Natural Enemies', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        2. Identification and Management of Insect Pests of Rice and their Natural Enemies
                    </option>
                    <option value="Ecological Engineering"
                        {{ in_array('Ecological Engineering', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        3. Ecological Engineering
                    </option>
                    <option value="AESA concepts and procedures"
                        {{ in_array('AESA concepts and procedures', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        4. Agroecosystems Analysis (AESA) concepts and procedures
                    </option>
                    <option value="Other Pests Management"
                        {{ in_array('Other Pests Management', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        5. Other Pests (Weeds, GAS, Rodents) and their management
                    </option>
                    <option value="Rice Disease Management"
                        {{ in_array('Rice Disease Management', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        6. Identification and Management of Major Diseases of Rice
                    </option>
                    <option value="PalayCheck Key Check 7"
                        {{ in_array('PalayCheck Key Check 7', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        7. PalayCheck System Key check 7: No significant yield loss due to pests
                    </option>
                </optgroup>

                <optgroup label="B. Integrated Nutrient Management">
                    <option value="INM Concepts and Fertilizer Management"
                        {{ in_array('INM Concepts and Fertilizer Management', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        1. INM Concept and Principles; Nutrient Facts and Management (Organic and Inorganic Fertilizer Materials; Fertilizer Computation)
                    </option>
                    <option value="MOET App"
                        {{ in_array('MOET App', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        2. The MOET and the Use of MOET App
                    </option>
                    <option value="LCC App"
                        {{ in_array('LCC App', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        3. The Use of LCC App
                    </option>
                    <option value="RCMAS"
                        {{ in_array('RCMAS', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        4. The use of RCMAS
                    </option>
                    <option value="Abonong Swak"
                        {{ in_array('Abonong Swak', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        5. Abonong Swak
                    </option>
                    <option value="PalayCheck Key Check 5"
                        {{ in_array('PalayCheck Key Check 5', old('three_topics', $selectedTopics)) ? 'selected' : '' }}>
                        6. PalayCheck System Key Check 5: Sufficient nutrients from tillering to early panicle initiation and flowering
                    </option>
                </optgroup>
            </select>

            </div>
        </div>
    </div>
</div>
<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-course-management-tab"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
</div>
</div>
<!-- end tab pane -->
