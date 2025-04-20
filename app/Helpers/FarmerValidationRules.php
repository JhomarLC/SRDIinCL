<?php

namespace App\Helpers;

class FarmerValidationRules
{
    public static function rules(string $step = 'all')
    {
        $rules = [
            'personal-info' => [
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'suffix' => 'nullable|string|max:50',
                'nickname' => 'nullable|string|max:100',
                'phone_number' => 'required|string|regex:/^[0-9]{10,15}$/',
                'birth_date' => 'required|date|before:today',
                'age_group' => 'required|string',
                'is_pwd' => 'required|boolean',
                'disability_type' => 'nullable|required_if:is_pwd,1|string',
                'is_indigenous' => 'required|boolean',
                'tribe_name' => 'nullable|required_if:is_indigenous,1|string',
                'gender' => 'required|string',
                'civil_status' => 'required|string',
                'religion' => 'required|string',
                'province_code' => 'required|string',
                'municipality_code' => 'required|string',
                'barangay_code' => 'required|string',
                'zip_code' => 'required|digits_between:4,6',
                'house_number_sitio_purok' => 'nullable|string',
                'primary_sector' => 'required|in:Farmer/Seed Grower,Extension Worker,Researcher,Educator,Student,Policy Maker,Media,Industry Player,Others',
                'years_in_farming' => 'required|integer|min:0|max:100',
                'farmer_association' => 'required|string',
                'education_level' => 'required|in:Elementary,High School,Vocational,College Degree,Masters Degree,Doctorate Degree,Undergraduate,Others',
                'farm_role' => 'required|in:Farm Owner,Relative of Farm Owner',
                'rsbsa_number' => 'nullable|string|max:50',
            ],
            'trainings' => [
                'training_title.*' => 'nullable|required_with:training_date.*,conducted_by.*,personally_paid.*|string|max:255',
                'training_date.*' => 'nullable|required_with:training_title.*,conducted_by.*,personally_paid.*|date',
                'conducted_by.*' => 'nullable|required_with:training_title.*,training_date.*,personally_paid.*|string|max:255',
                'personally_paid.*' => 'nullable|required_with:training_title.*,training_date.*,conducted_by.*',
            ],
            'other-info' => [
                'food_restriction' => 'nullable|string',
                'medical_condition' => 'nullable|string',
            ],
            'data-ricefarming' => [
                'season.*' => 'required|string|in:Wet Season,Dry Season',
                'year_training_conducted.*' => 'required|string',
                'farm_size_hectares.*' => 'required|numeric|min:0',
                'total_yield_caban.*' => 'required|numeric|min:0',
                'weight_per_caban_kg.*' => 'required|numeric|min:0',
                'price_per_kg.*' => 'required|numeric|min:0',
                'other_crops.*' => 'nullable|string|max:255',
            ],
            'emergency-contact' => [
                'ec_first_name' => 'required|string|max:255',
                'ec_middle_name' => 'nullable|string|max:255',
                'ec_last_name' => 'required|string|max:255',
                'ec_suffix' => 'nullable|string|max:50',
                'ec_relationship' => 'required|string|max:50',
                'ec_contact_number' => 'required|string|max:11',
            ],
            'training-result' => [
                'training_title_main' => 'required|string|max:255',
                'training_date_main' => 'required|date',
                'ts_province_code' => 'required|string',
                'ts_municipality_code' => 'required|string',
                'ts_barangay_code' => 'required|string',
                'pre_test_score' => 'required|numeric|min:0',
                'post_test_score' => 'required|numeric|min:0',
                'total_test_items' => 'required|numeric|min:1',
                'gain_in_knowledge' => 'required|numeric|min:0',

                'total_no_meetings' => 'nullable|numeric|min:0',
                'meetings_attended' => 'nullable|numeric|min:0',
                'percentage_meetings_attended' => 'nullable|numeric|min:0',

                'certificate_type' => 'required|string|max:100',
                'certificate_number' => 'required|string|max:100',
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
            'tribe_name.required_if' => 'Please enter tribe name if the person is indigenous.',
            'disability_type.required_if' => 'Please select type of disability_type if the person is PWD.',
            'zip_code.number' => 'The ZIP code must be a valid number.',

            'training_title.*.required_with' => 'Please enter the training title if you filled in date, agency, or payment information.',
            'training_date.*.required_with' => 'Please provide the training date if you entered title, agency, or payment info.',
            'conducted_by.*.required_with' => 'Please enter who conducted the training if you filled in title, date, or payment.',
            'personally_paid.*.required_with' => 'Please select whether you paid for the training if other training fields are filled.',

            'season.*.in' => 'Farming season must be either "Dry" or "Wet".',
            'year_training_conducted.*.date_format' => 'Year must be in YYYY format.',
            'farm_size_hectares.*.min' => 'Farm size must be 0 or greater.',
            'total_yield_caban.*.min' => 'Total yield caban must be 0 or greater.',
            'weight_per_caban_kg.*.min' => 'Weight per caban must be 0 or greater.',
            'price_per_kg.*.min' => 'Price per kilogram must be 0 or greater.',

            'pre_test_score.min' => 'Pre-test score cannot be negative.',
            'post_test_score.min' => 'Post-test score cannot be negative.',
            'total_test_items.min' => 'There must be at least 1 test item.',
            'gain_in_knowledge.min' => 'Gain in knowledge cannot be negative.',
        ];
    }
}
