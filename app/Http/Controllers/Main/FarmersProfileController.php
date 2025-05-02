<?php

namespace App\Http\Controllers\Main;

use App\Exports\FarmersProfileExport;
use App\Helpers\FarmerValidationRules;
use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use App\Models\FarmingData;
use App\Models\FoodRestrictions;
use App\Models\MedicalConditions;
use App\Models\Participant;
use App\Models\Training;
use App\Models\TrainingAttendance;
use App\Models\TrainingResults;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class FarmersProfileController extends Controller
{
    public function exportFarmersProfile(Request $request)
    {
        $province  = $request->input('province');
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        // start with a base name
        $filename = 'Farmers_Profile';

        // append province if given
        if ($province) {
            // sanitize (no spaces, uppercase)
            $filename .= '_' . strtoupper(str_replace(' ', '', $province));
        }

        // append date range if both given
        if ($startDate && $endDate) {
            $from = Carbon::parse($startDate)->format('Ymd');
            $to   = Carbon::parse($endDate)->format('Ymd');
            $filename .= "_{$from}_to_{$to}";
        }

        // optional: append a timestamp so repeated downloads don’t collide
        $filename .= '_' . now()->format('Ymd_His');

        // finally tack on the extension
        $filename .= '.xlsx';

        return Excel::download(
            new FarmersProfileExport($province, $startDate, $endDate),
            $filename
        );
    }

    public function validateStep(Request $request)
    {
        $step = $request->input('step');
        $rules = FarmerValidationRules::rules($step);
        $messages = FarmerValidationRules::messages();

        $validated = $request->validate($rules, $messages);

        return response()->json(['success' => true]);
    }

    public function validateAllSteps(Request $request)
    {
        $steps = ['personal-info', 'trainings', 'other-info', 'data-ricefarming', 'emergency-contact', 'training-result'];
        $messages = FarmerValidationRules::messages();

        $allErrors = [];

        foreach ($steps as $step) {
            $rules = FarmerValidationRules::rules($step);
            $validator = \Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $allErrors[$step] = $validator->errors()->messages();
            }
        }

        if (!empty($allErrors)) {
            return response()->json([
                'success' => false,
                'errors' => $allErrors,
            ], 422);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('farmers-profile.index');
    }


    public function getIndex()
    {
        $query = Participant::query()->latest();

        $user = auth()->user();

        if ($user->isAew()) {
            if ($user->isProvincialAew()) {
                // Only show participants within same province
                $query->where('province_code', $user->profile->province);
            } elseif ($user->isMunicipalAew()) {
                // Only show participants within same municipality
                $query->where('municipality_code', $user->profile->municipality);
            }
        }

        $participants = $query->get();

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

                return $participants->full_address;
            })
            ->addColumn('actions', function ($participants) {
                return '
                <a href="' . route('farmers-profile.show', $participants->id) . '" class="btn btn-sm btn-secondary editAdmin">
                    <i class="ri-eye-fill"></i> View
                </a>
                <a href="' . route('farmers-profile.edit', $participants->id) . '" class="btn btn-sm btn-success">
                    <i class="ri-eye-fill"></i> Update
                </a>
                <button class="btn btn-sm btn-danger status-deactivate">
                    <i class="ri-archive-fill"></i> Delete
                </button>
            ';
            })
            ->rawColumns(['full_name', 'phone_number', 'address', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('farmers-profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            FarmerValidationRules::rules('all'),
            FarmerValidationRules::messages()
        );

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
                'disability_type' => $validated['disability_type'] ?? null,
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
                $date = $validated['training_date'][$index] ?? null;
                $conductedBy = $validated['conducted_by'][$index] ?? null;
                $paid = $validated['personally_paid'][$index] ?? null;

                // ✅ Skip if all fields are empty/null
                if (empty($title) && empty($date) && empty($conductedBy) && empty($paid)) {
                    continue;
                }
                // 🧠 Optional: only require `title` at minimum
                Training::create([
                    'participant_id' => $participant->id,
                    'training_title' => $title,
                    'training_date' => $date,
                    'conducted_by' => $conductedBy,
                    'personally_paid' => $paid,
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
                    // 'total_income' => $validated['total_income'][$i],
                    // 'total_cost' => $validated['total_cost'][$i],
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
                'training_title_main' => $validated['training_title_main'],
                'training_date_main' => $validated['training_date_main'],
                // 'training_location_main' => $validated['training_location_main'],
                'ts_province_code' => $validated['ts_province_code'],
                'ts_municipality_code' => $validated['ts_municipality_code'],
                'ts_barangay_code' => $validated['ts_barangay_code'],

                'pre_test_score' => $validated['pre_test_score'],
                'post_test_score' => $validated['post_test_score'],
                'total_test_items' => $validated['total_test_items'],
                'gain_in_knowledge' => $validated['gain_in_knowledge'],

                'total_no_meetings' => $validated['total_no_meetings'],
                'meetings_attended' => $validated['meetings_attended'],
                'percentage_meetings_attended' => $validated['percentage_meetings_attended'],

                'certificate_type' => $validated['certificate_type'],
                'certificate_number' => $validated['certificate_number'],
                // 'overall_training_eval_score' => $validated['overall_training_eval_score'],
                // 'trainer_rating' => $validated['trainer_rating'],
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
        $participant = Participant::with([
            'training_results' => function ($query) {
                $query->latest();
            },
            'food_restrictions',
            'medical_conditions',
            'emergency_contact',
            'farming_data',
        ])->findOrFail($id);

        return view('farmers-profile.show',  compact(['participant']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $participant = Participant::with([
            'training_results' => function ($query) {
                $query->latest();
            },
            'food_restrictions',
            'medical_conditions',
            'emergency_contact',
            'farming_data',
            'trainings'
        ])->findOrFail($id);

        return view('farmers-profile.update', compact(['participant']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Step 1: Validate the request
        $validated = $request->validate(
            FarmerValidationRules::rules('all'),
            FarmerValidationRules::messages()
        );

        DB::beginTransaction();
        try {
            // 1. Find the participant
            $participant = Participant::findOrFail($id);

            // 2. Update participant data
            $participant->update([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'suffix' => $validated['suffix'] ?? null,
                'nickname' => $validated['nickname'] ?? null,
                'phone_number' => $validated['phone_number'],
                'birth_date' => $validated['birth_date'],
                'age_group' => $validated['age_group'],
                'is_pwd' => $validated['is_pwd'],
                'disability_type' => $validated['disability_type'] ?? null,
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

            // 3. Update Trainings (delete existing ones and create new ones)
            $participant->trainings()->delete(); // Remove existing trainings
            foreach ($validated['training_title'] as $index => $title) {
                $date = $validated['training_date'][$index] ?? null;
                $conductedBy = $validated['conducted_by'][$index] ?? null;
                $paid = $validated['personally_paid'][$index] ?? null;

                if (empty($title) && empty($date) && empty($conductedBy) && empty($paid)) {
                    continue;
                }

                Training::create([
                    'participant_id' => $participant->id,
                    'training_title' => $title,
                    'training_date' => $date,
                    'conducted_by' => $conductedBy,
                    'personally_paid' => $paid,
                ]);
            }

            // 4. Update other information (Food Restrictions, Medical Conditions)
            $participant->food_restrictions()->delete();
            if ($request->filled('food_restriction')) {
                $foodRestrictions = explode(',', $request->input('food_restriction'));
                foreach ($foodRestrictions as $item) {
                    FoodRestrictions::create([
                        'participant_id' => $participant->id,
                        'food_restriction' => trim($item),
                    ]);
                }
            }

            $participant->medical_conditions()->delete();
            if ($request->filled('medical_condition')) {
                $medicalConditions = explode(',', $request->input('medical_condition'));
                foreach ($medicalConditions as $item) {
                    MedicalConditions::create([
                        'participant_id' => $participant->id,
                        'medical_condition' => trim($item),
                    ]);
                }
            }

            // 5. Update Rice Farming Data
            $participant->farming_data()->delete();
            foreach ($validated['season'] as $i => $season) {
                FarmingData::create([
                    'participant_id' => $participant->id,
                    'season' => $season,
                    'year_training_conducted' => $validated['year_training_conducted'][$i],
                    'farm_size_hectares' => $validated['farm_size_hectares'][$i],
                    'total_yield_caban' => $validated['total_yield_caban'][$i],
                    'weight_per_caban_kg' => $validated['weight_per_caban_kg'][$i],
                    'price_per_kg' => $validated['price_per_kg'][$i],
                    'other_crops' => $validated['other_crops'][$i] ?? null,
                ]);
            }

            // 6. Update Emergency Contact
            $participant->emergency_contact()->update([
                'first_name' => $validated['ec_first_name'],
                'middle_name' => $validated['ec_middle_name'] ?? null,
                'last_name' => $validated['ec_last_name'],
                'suffix' => $validated['ec_suffix'] ?? null,
                'relationship' => $validated['ec_relationship'],
                'contact_number' => $validated['ec_contact_number'],
            ]);

            // 7. Update Training Results
            $participant->training_results()->update([
                'training_title_main' => $validated['training_title_main'],
                'training_date_main' => $validated['training_date_main'],
                // 'training_location_main' => $validated['training_location_main'],
                'ts_province_code' => $validated['ts_province_code'],
                'ts_municipality_code' => $validated['ts_municipality_code'],
                'ts_barangay_code' => $validated['ts_barangay_code'],

                'pre_test_score' => $validated['pre_test_score'],
                'post_test_score' => $validated['post_test_score'],
                'total_test_items' => $validated['total_test_items'],
                'gain_in_knowledge' => $validated['gain_in_knowledge'],

                'total_no_meetings' => $validated['total_no_meetings'],
                'meetings_attended' => $validated['meetings_attended'],
                'percentage_meetings_attended' => $validated['percentage_meetings_attended'],

                'certificate_type' => $validated['certificate_type'],
                'certificate_number' => $validated['certificate_number'],
                // 'overall_training_eval_score' => $validated['overall_training_eval_score'],
                // 'trainer_rating' => $validated['trainer_rating'],
            ]);

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Participant updated successfully!']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Failed to update participant.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
