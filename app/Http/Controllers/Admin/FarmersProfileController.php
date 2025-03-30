<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use App\Models\FarmingData;
use App\Models\FoodRestrictions;
use App\Models\MedicalConditions;
use App\Models\Participant;
use App\Models\Training;
use App\Models\TrainingAttendance;
use App\Models\TrainingResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
                'province_code' => 'required|string',
                'municipality_code' => 'required|string',
                'barangay_code' => 'required|string',
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
                'training_year.*' => 'required|string',
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

        if ($step == 'data-ricefarming') {
            $rules = [
                'season.*' => 'required|string|in:Wet Season,Dry Season',
                'year_training_conducted.*' => 'required|string',
                'farm_size_hectares.*' => 'required|numeric|min:0',
                'total_yield_caban.*' => 'required|numeric|min:0',
                'weight_per_caban_kg.*' => 'required|numeric|min:0',
                'price_per_kg.*' => 'required|numeric|min:0',
                'total_income.*' => 'required|numeric|min:0',
                'total_cost.*' => 'required|numeric|min:0',
                'other_crops.*' => 'nullable|string|max:255',
            ];

            $messages = [
                'season.*.required' => 'Please select the farming season.',
                'season.*.in' => 'Farming season must be either "Dry" or "Wet".',

                'year_training_conducted.*.required' => 'Please select the year conducted.',
                'year_training_conducted.*.date_format' => 'Year must be in YYYY format.',

                'farm_size_hectares.*.required' => 'Please enter farm size.',
                'farm_size_hectares.*.numeric' => 'Farm size must be a valid number.',
                'farm_size_hectares.*.min' => 'Farm size must be 0 or greater.',

                'total_yield_caban.*.required' => 'Please enter total yield caban.',
                'total_yield_caban.*.numeric' => 'Total yield caban must be a number.',
                'total_yield_caban.*.min' => 'Total yield caban must be 0 or greater.',

                'weight_per_caban_kg.*.required' => 'Please enter weight per caban.',
                'weight_per_caban_kg.*.numeric' => 'Weight per caban must be a number.',
                'weight_per_caban_kg.*.min' => 'Weight per caban must be 0 or greater.',

                'price_per_kg.*.required' => 'Please enter price per kilogram.',
                'price_per_kg.*.numeric' => 'Price per kilogram must be a number.',
                'price_per_kg.*.min' => 'Price per kilogram must be 0 or greater.',

                'total_income.*.required' => 'Please enter total income.',
                'total_income.*.numeric' => 'Total income must be a number.',
                'total_income.*.min' => 'Total income must be 0 or greater.',

                'total_cost.*.required' => 'Please enter total cost.',
                'total_cost.*.numeric' => 'Total cost must be a number.',
                'total_cost.*.min' => 'Total cost must be 0 or greater.',

                'other_crops.*.string' => 'Other crops must be a valid string.',
                'other_crops.*.max' => 'Other crops must not exceed 255 characters.',
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


    public function getIndex()
    {
        $participants = Participant::latest()->get();

        return DataTables::of($participants)
            ->editColumn('full_name', function ($participants) {
                $middleName = $participants->middle_name ? ' ' . $participants->middle_name : ''; // Add middle name if available
                $extName = $participants->suffix ? ' ' . $participants->suffix : ''; // Add middle name if available
                return "{$participants->first_name} {$middleName} {$participants->last_name} {$extName}";
            })
            ->addColumn('phone_number', function ($participants) {
                return $participants->phone_number ?? 'N/A'; // Safely access profile attribute
            })
            ->addColumn('address', function ($participants) {
                // Combine barangay, municipality, province
                return "{$participants->barangay->name}, {$participants->municipality->name}, {$participants->province->name}";
            })
            ->rawColumns(['full_name', 'phone_number', 'address'])
            ->make(true);
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
        $rules = [
            // Personal Information
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
            'province_code' => 'required|string',
            'municipality_code' => 'required|string',
            'barangay_code' => 'required|string',
            'zip_code' => 'required|digits_between:4,6',
            'house_number_sitio_purok' => 'nullable|string',
            'primary_sector' => 'required|in:Farmer/Seed Grower,Extension Worker,Researcher,Educator,Student,Policy Maker,Media,Industry Player,Others',
            'years_in_farming' => 'required|integer|min:0|max:100',
            'farmer_association' => 'required|string',
            'education_level' => 'required|in:Elementary,High School,Vocational,College Degree,Master’s Degree,Doctorate Degree,Undergraduate,Others',
            'farm_role' => 'required|in:Farm Owner,Relative of Farm Owner',
            'rsbsa_number' => 'required|string|max:50',

            // Trainings
            'training_title.*' => 'required|string|max:255',
            'training_year.*' => 'required|string',
            'conducted_by.*' => 'required|string|max:255',
            'personally_paid.*' => 'required|in:yes,no',

            // Other-Information
            'food_restriction' => 'nullable|string',
            'medical_condition' => 'nullable|string',

            // Rice Farming Data
            'season.*' => 'required|string|in:Wet Season,Dry Season',
            'year_training_conducted.*' => 'required|string',
            'farm_size_hectares.*' => 'required|numeric|min:0',
            'total_yield_caban.*' => 'required|numeric|min:0',
            'weight_per_caban_kg.*' => 'required|numeric|min:0',
            'price_per_kg.*' => 'required|numeric|min:0',
            'total_income.*' => 'required|numeric|min:0',
            'total_cost.*' => 'required|numeric|min:0',
            'other_crops.*' => 'nullable|string|max:255',

            // Emergency Contact
            'ec_first_name' => 'required|string|max:255',
            'ec_middle_name' => 'nullable|string|max:255',
            'ec_last_name' => 'required|string|max:255',
            'ec_suffix' => 'nullable|string|max:50',
            'ec_relationship' => 'required|string|max:50',
            'ec_contact_number' => 'required|string|max:11',

            // Training Result
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
            // Personal Information
            'tribe_name.required_if' => 'Please enter tribe name if the person is indigenous.',
            'disability.required_if' => 'Please select type of disability if the person is PWD.',
            'zip_code.number' => 'The ZIP code must be a valid number.',

            // Trainings
            'training_title.*.required' => 'Please enter the training title.',
            'training_year.*.required' => 'Please enter the date of training was conducted.',
            'conducted_by.*.required' => 'Please enter the agency name.',
            'personally_paid.*.required' => 'Please indicate if you paid for the training.',

            // Other Informations
            'food_restriction.string' => 'Food restriction must be a valid string.',
            'medical_condition.string' => 'Medical condition must be a valid string.',

            // Emergency Contact
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

            // Rice Farming Data
            'season.*.required' => 'Please select the farming season.',
            'season.*.in' => 'Farming season must be either "Dry" or "Wet".',

            'year_training_conducted.*.required' => 'Please select the year conducted.',
            'year_training_conducted.*.date_format' => 'Year must be in YYYY format.',

            'farm_size_hectares.*.required' => 'Please enter farm size.',
            'farm_size_hectares.*.numeric' => 'Farm size must be a valid number.',
            'farm_size_hectares.*.min' => 'Farm size must be 0 or greater.',

            'total_yield_caban.*.required' => 'Please enter total yield caban.',
            'total_yield_caban.*.numeric' => 'Total yield caban must be a number.',
            'total_yield_caban.*.min' => 'Total yield caban must be 0 or greater.',

            'weight_per_caban_kg.*.required' => 'Please enter weight per caban.',
            'weight_per_caban_kg.*.numeric' => 'Weight per caban must be a number.',
            'weight_per_caban_kg.*.min' => 'Weight per caban must be 0 or greater.',

            'price_per_kg.*.required' => 'Please enter price per kilogram.',
            'price_per_kg.*.numeric' => 'Price per kilogram must be a number.',
            'price_per_kg.*.min' => 'Price per kilogram must be 0 or greater.',

            'total_income.*.required' => 'Please enter total income.',
            'total_income.*.numeric' => 'Total income must be a number.',
            'total_income.*.min' => 'Total income must be 0 or greater.',

            'total_cost.*.required' => 'Please enter total cost.',
            'total_cost.*.numeric' => 'Total cost must be a number.',
            'total_cost.*.min' => 'Total cost must be 0 or greater.',

            'other_crops.*.string' => 'Other crops must be a valid string.',
            'other_crops.*.max' => 'Other crops must not exceed 255 characters.',

            // Training Result
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

        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            // 1. Save participant
            $participant = Participant::create([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'suffix' => $validated['suffix'] ?? null,
                'nickname' => $validated['nickname'] ?? null,
                'phone_number' => $validated['phone_number'],
                'birth_date' => $validated['birth_date'],
                'age_group' => $validated['age_group'],
                'is_pwd' => $validated['is_pwd'],
                'disability' => $validated['disability'] ?? null,
                'is_indigenous' => $validated['is_indigenous'],
                'tribe_name' => $validated['tribe_name'] ?? null,
                'gender' => $validated['gender'],
                'civil_status' => $validated['civil_status'],
                'religion' => $validated['religion'],
                'province_code' => $validated['province_code'],
                'municipality_code' => $validated['municipality_code'],
                'barangay_code' => $validated['barangay_code'],
                'zip_code' => $validated['zip_code'],
                'house_number_sitio_purok' => $validated['house_number_sitio_purok'] ?? null,
                'primary_sector' => $validated['primary_sector'],
                'years_in_farming' => $validated['years_in_farming'],
                'farmer_association' => $validated['farmer_association'],
                'education_level' => $validated['education_level'],
                'farm_role' => $validated['farm_role'],
                'rsbsa_number' => $validated['rsbsa_number'],
                'food_restriction' => $validated['food_restriction'] ?? null,
                'medical_condition' => $validated['medical_condition'] ?? null,
            ]);

            // 2. Save trainings
            foreach ($validated['training_title'] as $index => $title) {
                TrainingAttendance::create([
                    'participant_id' => $participant->id,
                    'training_title' => $title,
                    'training_year' => $validated['training_year'][$index],
                    'conducted_by' => $validated['conducted_by'][$index],
                    'personally_paid' => $validated['personally_paid'][$index] === 'yes',
                ]);
            }

            // 3. Other Info
            // 🔍 Step 2: Save Food Restrictions
            if ($request->filled('food_restriction')) {
                $foodRestrictions = explode(',', $request->input('food_restriction'));
                foreach ($foodRestrictions as $item) {
                    FoodRestrictions::create([
                        'participant_id' => $participant->id,
                        'food_restriction' => trim($item),
                    ]);
                }
            }

            // 🏥 Step 3: Save Medical Conditions
            if ($request->filled('medical_condition')) {
                $medicalConditions = explode(',', $request->input('medical_condition'));
                foreach ($medicalConditions as $item) {
                    MedicalConditions::create([
                        'participant_id' => $participant->id,
                        'medical_condition' => trim($item),
                    ]);
                }
            }

            // 4. Rice Farming Data
            foreach ($validated['season'] as $i => $season) {
                FarmingData::create([
                    'participant_id' => $participant->id,
                    'season' => $season,
                    'year_training_conducted' => $validated['year_training_conducted'][$i],
                    'farm_size_hectares' => $validated['farm_size_hectares'][$i],
                    'total_yield_caban' => $validated['total_yield_caban'][$i],
                    'weight_per_caban_kg' => $validated['weight_per_caban_kg'][$i],
                    'price_per_kg' => $validated['price_per_kg'][$i],
                    'total_income' => $validated['total_income'][$i],
                    'total_cost' => $validated['total_cost'][$i],
                    'other_crops' => $validated['other_crops'][$i] ?? null,
                ]);
            }

            // 5. Save emergency contact
            EmergencyContact::create([
                'participant_id' => $participant->id,
                'first_name' => $validated['ec_first_name'],
                'middle_name' => $validated['ec_middle_name'] ?? null,
                'last_name' => $validated['ec_last_name'],
                'suffix' => $validated['ec_suffix'] ?? null,
                'relationship' => $validated['ec_relationship'],
                'contact_number' => $validated['ec_contact_number'],
            ]);

            // 6. Save training results
            TrainingResults::create([
                'participant_id' => $participant->id,
                'pre_test_score' => $validated['pre_test_score'],
                'post_test_score' => $validated['post_test_score'],
                'total_test_items' => $validated['total_test_items'],
                'gain_in_knowledge' => $validated['gain_in_knowledge'],
                'certificate_type' => $validated['certificate_type'],
                'certificate_number' => $validated['certificate_number'],
                'overall_training_eval_score' => $validated['overall_training_eval_score'],
                'trainer_rating' => $validated['trainer_rating'],
            ]);


            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Participant registered successfully!']);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Failed to register participant.', 'error' => $e->getMessage()], 500);
        }
        // return response()->json(['status' => 'success', 'message' => 'Admin created successfully!', 'admin' => $admin]);
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
