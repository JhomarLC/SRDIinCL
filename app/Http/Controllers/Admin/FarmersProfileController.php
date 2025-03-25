<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Http\Request;

class FarmersProfileController extends Controller
{
    public function validateStep(Request $request)
    {
        $step = $request->input('step');

        if ($step == 'personal-info') {
            $rules = [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'nickname' => 'nullable|string|max:100',
            'phone_number' => 'required|string|regex:/^[0-9]{10,15}$/',
            'birth_date' => 'required|date|before:today',
            'age_group' => 'required|string',
            'is_pwd' => 'required|boolean',
            'disability' => 'nullable|required_if:is_pwd,1|string',
            'is_indigenous' => 'required|boolean',
            'tribe_name' => 'nullable|required_if:is_indigenous,1|string',
            'gender' => 'required|string',
            'civil_status' => 'required|string',
            'religion' => 'required|string',
            'province' => 'required|string',
            'municipality' => 'required|string',
            'barangay' => 'required|string',
            'zip_code' => 'required|digits_between:4,6',
            'house_number_sitio_purok' => 'nullable|string',
            'primary_sector' => 'required|in:Farmer/Seed Grower,Extension Worker,Researcher,Educator,Student,Policy Maker,Media,Industry Player,Others',
            'years_in_farming' => 'required|integer|min:0|max:100',
            'farmer_association' => 'required|string',
            'education_level' => 'required|in:Elementary,High School,Vocational,College Degree,Master’s Degree,Doctorate Degree,Undergraduate,Others',
            'farm_role' => 'required|in:Farm Owner,Relative of Farm Owner',
            'rsbsa_number' => 'required|string|max:50',
            ];
            $messages = [
                'tribe_name.required_if' => 'Please enter tribe name if the person is indigenous.',
                'disability.required_if' => 'Please select type of disability if the person is PWD.',
                'zip_code.number' => 'The ZIP code must be a valid number.',
            ];
        }

        if ($step == 'trainings') {
            $rules = [
                'training_title.*' => 'required|string|max:255',
                'training_year.*' => 'required',
                'conducted_by.*' => 'required|string|max:255',
                'personally_paid.*' => 'required|in:yes,no',
            ];

            $messages = [
                'training_title.*.required' => 'Please enter the training title.',
                'training_year.*.required' => 'Please enter the date of training was conducted.',
                'conducted_by.*.required' => 'Please enter the agency name.',
                'personally_paid.*.required' => 'Please indicate if you paid for the training.',
            ];
        }

        if ($step == 'other-info') {
            $rules = [
                'food_restriction' => 'nullable|string',
                'medical_condition' => 'nullable|string',
            ];

            $messages = [
                'food_restriction.string' => 'Food restriction must be a valid string.',
                'medical_condition.string' => 'Medical condition must be a valid string.',
            ];
        }

        if ($step == 'emergency-contact') {
            $rules = [
                'ec_first_name' => 'required|string|max:255',
                'ec_middle_name' => 'nullable|string|max:255',
                'ec_last_name' => 'required|string|max:255',
                'ec_suffix' => 'nullable|string|max:50',
                'ec_relationship' => 'required|string|max:50',
                'ec_contact_number' => 'required|string|max:11',
            ];

            $messages = [
                'ec_first_name.required' => 'First name is required.',
                'ec_first_name.string' => 'First name must be a valid string.',
                'ec_first_name.max' => 'First name may not be greater than 255 characters.',

                'ec_middle_name.string' => 'Middle name must be a valid string.',
                'ec_middle_name.max' => 'Middle name may not be greater than 255 characters.',

                'ec_last_name.required' => 'Last name is required.',
                'ec_last_name.string' => 'Last name must be a valid string.',
                'ec_last_name.max' => 'Last name may not be greater than 255 characters.',

                'ec_suffix.string' => 'Suffix must be a valid string.',
                'ec_suffix.max' => 'Suffix may not be greater than 50 characters.',

                'ec_relationship.required' => 'Relationship is required.',
                'ec_relationship.string' => 'Relationship must be a valid string.',
                'ec_relationship.max' => 'Relationship may not be greater than 50 characters.',

                'ec_contact_number.required' => 'Contact number is required.',
                'ec_contact_number.string' => 'Contact number must be a valid string.',
                'ec_contact_number.max' => 'Contact number may not be more than 11 digits.',
            ];
        }

        if ($step == 'training-result') {
            $rules = [
                'pre_test_score' => 'required|numeric|min:0',
                'post_test_score' => 'required|numeric|min:0',
                'total_test_items' => 'required|numeric|min:1',
                'gain_in_knowledge' => 'required|numeric|min:0',
                'certificate_type' => 'required|string|max:100',
                'certificate_number' => 'required|string|max:100',
                'overall_training_eval_score' => 'required|numeric|min:0|max:100',
                'trainer_rating' => 'required|numeric|min:1|max:5',
            ];

            $messages = [
                'pre_test_score.required' => 'Pre-test score is required.',
                'pre_test_score.numeric' => 'Pre-test score must be a number.',
                'pre_test_score.min' => 'Pre-test score cannot be negative.',

                'post_test_score.required' => 'Post-test score is required.',
                'post_test_score.numeric' => 'Post-test score must be a number.',
                'post_test_score.min' => 'Post-test score cannot be negative.',

                'total_test_items.required' => 'Total number of test items is required.',
                'total_test_items.numeric' => 'Total test items must be a number.',
                'total_test_items.min' => 'There must be at least 1 test item.',

                'gain_in_knowledge.required' => 'Gain in knowledge is required.',
                'gain_in_knowledge.numeric' => 'Gain in knowledge must be a number.',
                'gain_in_knowledge.min' => 'Gain in knowledge cannot be negative.',

                'certificate_type.required' => 'Certificate type is required.',
                'certificate_type.string' => 'Certificate type must be a valid string.',
                'certificate_type.max' => 'Certificate type may not be greater than 100 characters.',

                'certificate_number.required' => 'Certificate number is required.',
                'certificate_number.string' => 'Certificate number must be a valid string.',
                'certificate_number.max' => 'Certificate number may not be greater than 100 characters.',

                'overall_training_eval_score.required' => 'Training evaluation score is required.',
                'overall_training_eval_score.numeric' => 'Training evaluation score must be a number.',
                'overall_training_eval_score.min' => 'Evaluation score cannot be negative.',
                'overall_training_eval_score.max' => 'Evaluation score cannot exceed 100.',

                'trainer_rating.required' => 'Trainer rating is required.',
                'trainer_rating.numeric' => 'Trainer rating must be a number.',
                'trainer_rating.min' => 'Trainer rating must be at least 1.',
                'trainer_rating.max' => 'Trainer rating may not exceed 5.',
            ];
        }


        $validated = $request->validate($rules, $messages);

        return response()->json(['success' => true]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.farmers-profile.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.farmers-profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
