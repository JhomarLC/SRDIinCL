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
                <tr>
                    <td>Training objectives</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="objective_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="objective_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="objective_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="objective_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="objective_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="objective_comment"></textarea></td>
                </tr>
                <tr>
                    <td>Relevance of the training or course to your work/duties</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="relevance_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="relevance_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="relevance_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="relevance_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="relevance_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="relevance_comment"></textarea></td>
                </tr>
                <tr>
                    <td>Content of the training</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="content_completeness_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="content_completeness_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="content_completeness_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="content_completeness_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="content_completeness_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="content_completeness_comment"></textarea></td>
                </tr>
                <tr>
                    <td>Sufficient combination of lecture and hands-on</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="lecture_hands_on_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="lecture_hands_on_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="lecture_hands_on_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="lecture_hands_on_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="lecture_hands_on_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="lecture_hands_on_comment"></textarea></td>
                </tr>
                <tr>
                    <td>Sequence or arrangement of topics</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="sequence_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="sequence_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="sequence_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="sequence_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="sequence_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="sequence_comment"></textarea></td>
                </tr>
                <tr>
                    <td>Duration of the training</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="duration_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="duration_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="duration_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="duration_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="duration_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="duration_comment"></textarea></td>
                </tr>
                <tr>
                    <td>Method of examination</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="assessment_method_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="assessment_method_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="assessment_method_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="assessment_method_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="assessment_method_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="assessment_method_comment"></textarea></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <label for="low_score_comment" class="form-label">Reason or comment for any rating lower than 3 (Good):</label>
        <textarea class="form-control" id="low_score_comment" name="low_score_comment" rows="3"></textarea>
    </div>

    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-12">
                <label for="gender" class="form-label">List 3 topics that you think would be helpful in your current work/duties</label>
                {{-- <select class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="choices-multiple-remove-button"
                      multiple>
                        <option value="Choice 1" selected>Choice 1</option>
                        <option value="Choice 2">Choice 2</option>
                        <option value="Choice 3">Choice 3</option>
                        <option value="Choice 4">Choice 4</option>
                    </select>
                </div> --}}
                <select class="form-control" id="choices-multiple-remove-button" data-choices data-choices-limit="3" data-choices-removeItem name="choices-multiple-remove-button"
                    multiple>
                    <option selected disabled hidden>-- SELECT TOPIC DISCUSSED --</option>

                    <optgroup label="A. Overview of the PalayCheck System">
                        <option value="Overview of the PalayCheck System">1. Overview of the PalayCheck System</option>
                    </optgroup>

                    <optgroup label="C. Integrated Pest Management">
                        <option value="IPM concepts and principles">1. IPM concepts and principles</option>
                        <option value="Insect Pests and Natural Enemies">2. Identification and Management of Insect Pests of Rice and their Natural Enemies</option>
                        <option value="Ecological Engineering">3. Ecological Engineering</option>
                        <option value="AESA concepts and procedures">4. Agroecosystems Analysis (AESA) concepts and procedures</option>
                        <option value="Other Pests Management">5. Other Pests (Weeds, GAS, Rodents) and their management</option>
                        <option value="Rice Disease Management">6. Identification and Management of Major Diseases of Rice</option>
                        <option value="PalayCheck Key Check 7">7. PalayCheck System Key check 7: No significant yield loss due to pests</option>
                    </optgroup>

                    <optgroup label="B. Integrated Nutrient Management">
                        <option value="INM Concepts and Fertilizer Management">1. INM Concept and Principles; Nutrient Facts and Management (Organic and Inorganic Fertilizer Materials; Fertilizer Computation)</option>
                        <option value="MOET App">2. The MOET and the Use of MOET App</option>
                        <option value="LCC App">3. The Use of LCC App</option>
                        <option value="RCMAS">4. The use of RCMAS</option>
                        <option value="Abonong Swak">5. Abonong Swak</option>
                        <option value="PalayCheck Key Check 5">6. PalayCheck System Key Check 5: Sufficient nutrients from tillering to early panicle initiation and flowering</option>
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
