<?php

namespace App\Helpers;

class TrainingValidationRules
{
    public static function rules(string $step = 'all')
    {
        $rules = [
            'training-content' => [
                'objective_score' => 'required',
                'relevance_score' => 'required',
                'content_completeness_score' => 'required',
                'lecture_hands_on_score' => 'required',
                'sequence_score' => 'required',
                'duration_score' => 'required',
                'assessment_method_score' => 'required',

                'objective_comment' => 'nullable',
                'relevance_comment' => 'nullable',
                'content_completeness_comment' => 'nullable',
                'lecture_hands_on_comment' => 'nullable',
                'sequence_comment' => 'nullable',
                'duration_comment' => 'nullable',
                'assessment_method_comment' => 'nullable',

                'low_score_comment' => 'nullable',

                'topic_name' => 'nullable'
            ],
            'course-management' => [
                'coordination_score' => 'required',
                'time_management_score' => 'required',
                'speaker_quality_score' => 'required',
                'facilitators_score' => 'required',
                'support_staff_score' => 'required',
                'materials_score' => 'required',
                'facility_score' => 'required',
                'accommodation_score' => 'required',
                'food_quality_score' => 'required',
                'transportation_score' => 'required',
                'overall_management_score' => 'required',

                'coordination_comment' => 'nullable',
                'time_management_comment' => 'nullable',
                'speaker_quality_comment' => 'nullable',
                'facilitators_comment' => 'nullable',
                'support_staff_comment' => 'nullable',
                'materials_comment' => 'nullable',
                'facility_comment' => 'nullable',
                'accommodation_comment' => 'nullable',
                'food_quality_comment' => 'nullable',
                'transportation_comment' => 'nullable',
                'overall_management_comment' => 'nullable',

                'low_score_comment' => 'nullable',
            ],
            'overall-evaluation' => [
                'goal_achievement' => 'required|string|max:255',
                'overall_quality' => 'required|string|max:255',
                'additional_feedback_or_suggestions' => 'nullable|string|max:255',
                'recommend_training' => 'required|boolean',
                'recommendation_reason' => 'nullable|required_if:recommend_training,1|string',
                'preferred_future_trainings' => 'nullable|string|max:255',
                'employee_name.*' => 'nullable|required_with:employee_reason.*|string|max:255',
                'employee_reason.*' => 'nullable|required_with:employee_name.*|string|max:255',
             ],
             'personal-info' => [
                'first_name' => 'nullable|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:50',
                'age_group' => 'required|string',
                'sex' => 'required|string',
                'province_code' => 'required|string',
                'primary_sector' => 'required|in:Farmer/Seed Grower,Extension Worker,Researcher,Educator,Student,Policy Maker,Media,Industry Player,Others',
             ],
        ];

        if ($step === 'all') {
            return array_merge(...array_values($rules));
        }

        return $rules[$step] ?? [];
    }

    public static function messages()
    {
        return [
            'objective_score.required' => 'Please provide a score for the objectives.',
            'relevance_score.required' => 'Please provide a score for relevance.',
            'content_completeness_score.required' => 'Please provide a score for content completeness.',
            'lecture_hands_on_score.required' => 'Please provide a score for lecture and hands-on activities.',
            'sequence_score.required' => 'Please provide a score for the sequence of the training.',
            'duration_score.required' => 'Please provide a score for the duration of the training.',
            'assessment_method_score.required' => 'Please provide a score for the assessment method.',

            'employee_name.*.required_with' => 'Please provide the employee name if a reason is entered.',
            'employee_reason.*.required_with' => 'Please provide the reason if an employee name is entered.',

            'coordination_score.required' => 'Please provide a score for coordination.',
            'time_management_score.required' => 'Please provide a score for time management.',
            'speaker_quality_score.required' => 'Please provide a score for the quality of the speaker.',
            'facilitators_score.required' => 'Please provide a score for the facilitators.',
            'support_staff_score.required' => 'Please provide a score for the support staff.',
            'materials_score.required' => 'Please provide a score for the materials used.',
            'facility_score.required' => 'Please provide a score for the facility.',
            'accommodation_score.required' => 'Please provide a score for the accommodation.',
            'food_quality_score.required' => 'Please provide a score for the quality of food.',
            'transportation_score.required' => 'Please provide a score for the transportation.',
            'overall_management_score.required' => 'Please provide a score for overall management.',

            'recommendation_reason.required_if' => 'Please enter reason if you want to recommend this training.',
        ];
    }
}
