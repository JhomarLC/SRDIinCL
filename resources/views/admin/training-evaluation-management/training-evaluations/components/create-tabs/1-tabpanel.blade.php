<div class="tab-pane fade show active" id="pills-personal-info" role="tabpanel"
aria-labelledby="pills-personal-info-tab">
<div>
    <div>
        <h5>Training Content</h5>
        <p class="text-muted">Fill all information below</p>
    </div>
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-4">
                <label for="training_date" class="form-label">Date of Training</label>
                <input type="date" class="form-control" id="training_date">
            </div>
        </div>
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
                    <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="coordination_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="coordination_score_reason"></textarea></td>
                </tr>
                <tr>
                    <td>Relevance of the training or course to your work/duties</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="time_management_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="time_management_score_reason"></textarea></td>
                </tr>
                <tr>
                    <td>Content of the training</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="speaker_quality_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="speaker_quality_score_reason"></textarea></td>
                </tr>
                <tr>
                    <td>Sufficient combination of lecture and hands-on</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facilitators_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="facilitators_score_reason"></textarea></td>
                </tr>
                <tr>
                    <td>Sequence or arrangement of topics</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="support_staff_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="support_staff_score_reason"></textarea></td>
                </tr>
                <tr>
                    <td>Duration of the training</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="materials_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="materials_score_reason"></textarea></td>
                </tr>
                <tr>
                    <td>Method of examination</td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="5"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="4"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="3"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="2"></td>
                    <td class="text-center"><input class="form-check-input" type="radio" name="facility_score" value="1"></td>
                    <td><textarea type="text" class="form-control" name="facility_score_reason"></textarea></td>
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
                <select class="form-control mb-3 select2" id="gender" aria-label="Default select example">
                    <option selected disabled hidden>-- SELECT TOPICS --</option>
                    <option value="1">Overview of PalayCheck System</option>
                    <option value="2">IPM Concepts and Principles</option>
                    <option value="3">Identification and Management of Insect Pests of Rice and their Natural Enemies</option>
                    <option value="4">Ecological Engineering</option>
                    <option value="5">Agroecosystems Analysis (AESA) Concepts and Procedures</option>
                    <option value="6">Other Pests (Weeds, GAS, Rodents) and their Management</option>
                    <option value="7">Identification and Management of Major Diseases of Rice</option>
                    <option value="8">PalayCheck System Key Check 7: No significant yield loss due to pests</option>
                    <option value="9">INM Concept and Principles; Nutrient Facts and Management (Organic and Inorganic Fertilizer Materials; Fertilizer Computation)</option>
                    <option value="10">The MOET and the Use of MOET App</option>
                    <option value="11">The Use of LCC App</option>
                    <option value="12">The Use of RCMAS</option>
                    <option value="13">Abonong Swak</option>
                    <option value="14">PalayCheck System Key Check 5: Sufficient nutrients from tillering to early panicle initiation and flowering</option>
                </select>
            </div>
        </div>

    </div>
</div>
<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-success btn-label right ms-auto nexttab"
        data-nexttab="pills-trainings-tab"><i
            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
</div>
</div>
<!-- end tab pane -->
