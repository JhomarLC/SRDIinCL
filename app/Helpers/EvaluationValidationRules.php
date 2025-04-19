<?php

namespace App\Helpers;

class EvaluationValidationRules
{
    public static function rules(string $step = 'all')
    {
        $rules = [
            'speaker-evaluation' => [
                'knowledge_score' => 'required',
                'teaching_method_score' => 'required',
                'audiovisual_score' => 'required',
                'clarity_score' => 'required',
                'question_handling_score' => 'required',
                'audience_connection_score' => 'required',
                'content_relevance_score' => 'required',
                'goal_achievement_score' => 'required',

                'knowledge_score_comment' => 'nullable',
                'teaching_method_comment' => 'nullable',
                'audiovisual_comment' => 'nullable',
                'clarity_comment' => 'nullable',
                'question_handling_comment' => 'nullable',
                'audience_connection_comment' => 'nullable',
                'content_relevance_comment' => 'nullable',
                'goal_achievement_comment' => 'nullable',

                'additional_feedback' => 'nullable',
            ],
            'evaluation-personal-info' => [
               'first_name' => 'nullable|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:50',
                'age_group' => 'required|string',
                'is_pwd' => 'required|boolean',
                'disability_type' => 'nullable|required_if:is_pwd,1|string',
                'is_indigenous' => 'required|boolean',
                'tribe_name' => 'nullable|required_if:is_indigenous,1|string',
                'gender' => 'required|string',
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
            'knowledge_score.required' => 'Please provide a score for knowledge.',
            'teaching_method_score.required' => 'Please provide a score for teaching method.',
            'audiovisual_score.required' => 'Please provide a score for audiovisual materials.',
            'clarity_score.required' => 'Please provide a score for clarity.',
            'question_handling_score.required' => 'Please provide a score for question handling.',
            'audience_connection_score.required' => 'Please provide a score for audience connection.',
            'content_relevance_score.required' => 'Please provide a score for content relevance.',
            'goal_achievement_score.required' => 'Please provide a score for goal achievement.',

            'tribe_name.required_if' => 'Please enter tribe name if the person is indigenous.',
            'disability_type.required_if' => 'Please select type of disability_type if the person is PWD.',
        ];
    }
}
