<div class="tab-pane fade show active" id="pills-speaker-evaluation" role="tabpanel"
    aria-labelledby="pills-speaker-evaluation-tab">
        <div>
            <h5>Speaker Evaluation</h5>
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
                        <td>Knowledge and expertise in the subject or technology being taught
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="knowledge_score" value="5"
                            {{ $evaluation->knowledge_score == 5 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="knowledge_score" value="4"
                            {{ $evaluation->knowledge_score == 4 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="knowledge_score" value="3"
                            {{ $evaluation->knowledge_score == 3 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="knowledge_score" value="2"
                            {{ $evaluation->knowledge_score == 2 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="knowledge_score" value="1"
                            {{ $evaluation->knowledge_score == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea type="text" class="form-control" name="knowledge_score_comment" id="knowledge_score_comment">{{ old('knowledge_score_comment', $evaluation->knowledge_score_comment) }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Appropriateness and effectiveness of the teaching methods used</td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="teaching_method_score" value="5"
                            {{ $evaluation->teaching_method_score == 5 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="teaching_method_score" value="4"
                            {{ $evaluation->teaching_method_score == 4 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="teaching_method_score" value="3"
                            {{ $evaluation->teaching_method_score == 3 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="teaching_method_score" value="2"
                            {{ $evaluation->teaching_method_score == 2 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="teaching_method_score" value="1"
                            {{ $evaluation->teaching_method_score == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea type="text" class="form-control" name="teaching_method_comment" id="teaching_method_comment"> {{ old('teaching_method_comment', $evaluation->teaching_method_comment) }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Use and quality of audio visual aids</td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audiovisual_score" value="5"
                            {{ $evaluation->audiovisual_score == 5 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audiovisual_score" value="4"
                            {{ $evaluation->audiovisual_score == 4 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audiovisual_score" value="3"
                            {{ $evaluation->audiovisual_score == 3 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audiovisual_score" value="2"
                            {{ $evaluation->audiovisual_score == 2 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audiovisual_score" value="1"
                            {{ $evaluation->audiovisual_score == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea type="text" class="form-control" name="audiovisual_comment" id="audiovisual_comment">{{ old('audiovisual_comment', $evaluation->audiovisual_comment) }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Clarity of presentation and explanation</td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="clarity_score" value="5"
                            {{ $evaluation->clarity_score == 5 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="clarity_score" value="4"
                            {{ $evaluation->clarity_score == 4 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="clarity_score" value="3"
                            {{ $evaluation->clarity_score == 3 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="clarity_score" value="2"
                            {{ $evaluation->clarity_score == 2 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="clarity_score" value="1"
                            {{ $evaluation->clarity_score == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea type="text" class="form-control" name="clarity_comment" id="clarity_comment">{{ old('clarity_comment', $evaluation->clarity_comment) }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Ability to answer questions</td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="question_handling_score" value="5"
                            {{ $evaluation->question_handling_score == 5 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="question_handling_score" value="4"
                            {{ $evaluation->question_handling_score == 4 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="question_handling_score" value="3"
                            {{ $evaluation->question_handling_score == 3 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="question_handling_score" value="2"
                            {{ $evaluation->question_handling_score == 2 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="question_handling_score" value="1"
                            {{ $evaluation->question_handling_score == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea type="text" class="form-control" name="question_handling_comment" id="question_handling_comment">{{ old('question_handling_comment', $evaluation->question_handling_comment) }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Ability to make the topic appropriate to the level of participants</td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audience_connection_score" value="5"
                            {{ $evaluation->audience_connection_score == 5 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audience_connection_score" value="4"
                            {{ $evaluation->audience_connection_score == 4 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audience_connection_score" value="3"
                            {{ $evaluation->audience_connection_score == 3 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audience_connection_score" value="2"
                            {{ $evaluation->audience_connection_score == 2 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="audience_connection_score" value="1"
                            {{ $evaluation->audience_connection_score == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea type="text" class="form-control" name="audience_connection_comment" id="audience_connection_comment">{{ old('audience_connection_comment', $evaluation->audience_connection_comment) }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Connection with participants and audience</td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="content_relevance_score" value="5"
                            {{ $evaluation->content_relevance_score == 5 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="content_relevance_score" value="4"
                            {{ $evaluation->content_relevance_score == 4 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="content_relevance_score" value="3"
                            {{ $evaluation->content_relevance_score == 3 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="content_relevance_score" value="2"
                            {{ $evaluation->content_relevance_score == 2 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="content_relevance_score" value="1"
                            {{ $evaluation->content_relevance_score == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea type="text" class="form-control" name="content_relevance_comment" id="content_relevance_comment">{{ old('content_relevance_comment', $evaluation->content_relevance_comment) }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Achievement of the training objectives</td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="goal_achievement_score" value="5"
                            {{ $evaluation->goal_achievement_score == 5 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="goal_achievement_score" value="4"
                            {{ $evaluation->goal_achievement_score == 4 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="goal_achievement_score" value="3"
                            {{ $evaluation->goal_achievement_score == 3 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="goal_achievement_score" value="2"
                            {{ $evaluation->goal_achievement_score == 2 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="radio" name="goal_achievement_score" value="1"
                            {{ $evaluation->goal_achievement_score == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea type="text" class="form-control" name="goal_achievement_comment" id="goal_achievement_comment">{{ old('goal_achievement_comment', $evaluation->goal_achievement_comment) }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <label for="additional_feedback" class="form-label">Other additional comments or suggestions for the improvement of the speaker:</label>
            <textarea class="form-control" id="additional_feedback" name="additional_feedback" rows="3">{{ old('additional_feedback', $evaluation->additional_feedback) }}</textarea>
        </div>

        <div class="d-flex align-items-start gap-3 mt-4">
            <button type="button"
                class="btn btn-success btn-label right ms-auto nexttab"
                data-nexttab="pills-evaluation-personal-info-tab"><i
                    class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
        </div>
    </div>
