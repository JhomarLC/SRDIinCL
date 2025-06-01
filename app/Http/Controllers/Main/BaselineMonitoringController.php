<?php

namespace App\Http\Controllers\Main;

use App\Helpers\BaselineValidationRules;
use App\Helpers\SeasonHelper;
use App\Models\CropEstablishment;
use App\Models\CropEstablishmentParticulars;
use App\Models\FarmingData;
use App\Models\FertilizerApplication;
use App\Models\FertilizerApplicationItem;
use App\Models\FertilizerApplicationLabor;
use App\Models\LandPreparation;
use App\Models\LandPreparationParticulars;
use App\Models\Participant;
use App\Models\SeedBedFertilizationFertilizers;
use App\Models\SeedBedFertilizationParticulars;
use App\Models\SeedBedFertilizations;
use App\Models\SeedBedPreparation;
use App\Models\SeedBedPreparationParticulars;
use App\Models\SeedsPreparation;
use App\Models\SeedsPreparationParticulars;
use App\Models\Variety;
use App\Models\WaterIrrigation;
use App\Models\WaterIrrigationDetails;
use App\Models\WaterManagement;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class BaselineMonitoringController extends Controller
{
     public function validateStep(Request $request)
    {
        $step = $request->input('step');
        $rules = BaselineValidationRules::rules($step);
        $messages = BaselineValidationRules::messages();

        $validated = $request->validate($rules, $messages);

        return response()->json(['success' => true]);
    }

    public function validateAllSteps(Request $request)
    {
        $steps = ['all'];
        $messages = BaselineValidationRules::messages();

        $allErrors = [];

        foreach ($steps as $step) {
            $rules = BaselineValidationRules::rules($step);
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
        $participants = Participant::with([
            'farming_data'
        ])->get();


        $participant_farming_data = Participant::with([
            'farming_data.land_preparation.particulars',
            'farming_data.seeds_preparation.particulars',
            'farming_data.seeds_preparation.seedVarieties',
            'farming_data.seedbed_preparation.particulars',
            'farming_data.seedbed_fertilizations.particulars',
            'farming_data.seedbed_fertilizations.fertilizers',
            'farming_data.crop_establishment.particulars',
            'farming_data.fertilizer_applications.items',
            'farming_data.fertilizer_applications.labors',
            'farming_data.water_management.irrigations.details'
        ])->get();

        // return response()->json($participants);
        return view('baseline-monitoring.index', compact(['participants', 'participant_farming_data']));
    }

    public function getIndex(Request $request)
    {
        $query = Participant::query()->latest();

        // Filter by province
        if (!empty($request->province)) {
            $query->whereHas('training_results', function ($q) use ($request) {
                $q->where('ts_province_code', $request->province);
            });
        }

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
            ->addColumn('address', function ($participants) {
                return $participants->full_address;
            })
            ->addColumn('wet_season', function ($participants) {
                // $wetRecord = $participants->farming_data
                //                 ->where('season', 'Wet Season')
                //                 ->first();

                // if (
                //     $wetRecord &&
                //     (
                //         $wetRecord->activities->flatMap->details->isNotEmpty() ||
                //         $wetRecord->activities->flatMap->irrigationEvents->isNotEmpty()
                //     )
                // ) {
                //     return '<span class="badge bg-success">Baseline Complete</span>';
                // } else {
                // }
                return '<span class="badge bg-danger">No Baseline</span>';
            })
            ->addColumn('dry_season', function ($participants) {
                // $dryRecord = $participants->farming_data
                //                 ->where('season', 'Dry Season')
                //                 ->first();

                // if (
                //     $dryRecord &&
                //     (
                //         $dryRecord->activities->flatMap->details->isNotEmpty() ||
                //         $dryRecord->activities->flatMap->irrigationEvents->isNotEmpty()
                //     )
                // ) {
                //     return '<span class="badge bg-success">Baseline Complete</span>';
                // } else {
                // }
                return '<span class="badge bg-danger">No Baseline</span>';
            })

            ->addColumn('actions', function ($participants) {
                return '
                <a href="' . route('baseline-monitoring.show', $participants->id) . '" class="btn btn-sm btn-secondary editAdmin">
                    <i class="ri-eye-fill"></i> View Baseline
                </a>

                <button class="btn btn-sm btn-danger status-deactivate">
                    <i class="ri-archive-fill"></i> Delete
                </button>
            ';
            })
            ->rawColumns(['dry_season', 'wet_season', 'actions'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id, $season)
    {
        $participant = Participant::with('farming_data')->findOrFail($id);
        $normalizedSeason = ucwords(str_replace('-', ' ', $season));
        // Filter farming_data by the given season
        $filteredFarmingData = $participant->farming_data->where('season', $normalizedSeason);

        $varieties = Variety::orderBy('name')->get();

        // Generate year options using your helper
        $yearOptions = SeasonHelper::yearOptions(2021, $season);

        return view('baseline-monitoring.create', compact([
            'participant',
            'season',
            'normalizedSeason',
            'yearOptions',
            'varieties',
            'filteredFarmingData',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id, $season)
    {
        // Skip seedbed prep and fertilization if crop_est_method is DWSR
        $request->merge(['crop_est_method' => $request->input('crop_est_method')]);

        $validated = $request->validate(
            BaselineValidationRules::rules('all'),
            BaselineValidationRules::messages()
        );

        DB::beginTransaction();

        try {
            /**
             * 1. Save Land Preparation
             */
            $landPrep = LandPreparation::create([
                'farming_data_id' => $id,
                'is_pakyaw' => $validated['land_prep_is_pakyaw'],
                'package_cost' => $validated['land_prep_package_cost'] ?? null,
            ]);

            if (!$validated['land_prep_is_pakyaw']) {
                foreach ($request->input('land_prep', []) as $activity) {
                    LandPreparationParticulars::create([
                        'land_preparation_id' => $landPrep->id,
                        'activity' => $activity['activity'],
                        'qty' => $activity['qty'] ?? 0,
                        'unit_cost' => $activity['unit_cost'] ?? 0,
                        'total_cost' => $activity['total_cost'] ?? 0,
                    ]);
                }
            }

            /**
             * 2. Save Seeds Preparation
             */
            $seedsPrep = SeedsPreparation::create([
                'farming_data_id' => $id,
                'is_pakyaw' => $validated['seeds_prep_is_pakyaw'] ?? 0,
                'package_cost' => $validated['seeds_prep_package_cost'] ?? null,
                'others' => $request->input('seeds_prep_others'),
            ]);

            if (!$validated['seeds_prep_is_pakyaw']) {
                foreach ($request->input('seed_prep', []) as $activity) {
                    SeedsPreparationParticulars::create([
                        'seeds_preparation_id' => $seedsPrep->id,
                        'activity' => $activity['activity'],
                        'qty' => $activity['qty'] ?? 0,
                        'unit_cost' => $activity['unit_cost'] ?? 0,
                        'total_cost' => $activity['total_cost'] ?? 0,
                    ]);
                }
            }

            /**
             * 3. Save Seed Varieties (if any)
             */
            foreach ($request->input('seed_varieties', []) as $variety) {
                DB::table('seed_preparation_varieties')->insert([
                    'seeds_preparation_id' => $seedsPrep->id,
                    'seed_variety_id' => $variety['seed_variety_id'] ?? null,
                    'variety_name' => $variety['variety_name'],
                    'purchase_type' => $variety['purchase_type'],
                    'qty' => $variety['qty'] ?? 0,
                    'unit_cost' => $variety['unit_cost'] ?? 0,
                    'total_cost' => $variety['total_cost'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($request->input('crop_est_method') !== 'DWSR') {
                // Save Seedbed Prep and Fertilization

                /**
                 * 4. Save Seedbed Preparation
                 */
                $seedbedPrep = SeedBedPreparation::create([
                    'farming_data_id' => $id,
                    'is_pakyaw' => $validated['seedbed_prep_is_pakyaw'] ?? 0,
                    'package_cost' => $validated['seedbed_prep_package_cost'] ?? null,
                ]);

                if (!$validated['seedbed_prep_is_pakyaw']) {
                    foreach ($request->input('seedbed_prep', []) as $activity) {
                        SeedBedPreparationParticulars::create([
                            'seed_bed_preparation_id' => $seedbedPrep->id,
                            'activity' => $activity['activity'],
                            'qty' => $activity['qty'] ?? 0,
                            'unit_cost' => $activity['unit_cost'] ?? 0,
                            'total_cost' => $activity['total_cost'] ?? 0,
                        ]);
                    }
                }

                /**
                 * 5. Save Seedbed Fertilization
                 */
                $seedbedFertilization = SeedBedFertilizations::create([
                    'farming_data_id' => $id,
                    'others' => $request->input('seedbed_fertilization_others'),
                ]);

                // No pakyaw check – just loop if any input exists
                foreach ($request->input('seedbed_fertilization', []) as $activity) {
                    SeedBedFertilizationParticulars::create([
                        'seed_bed_fertilizations_id' => $seedbedFertilization->id,
                        'activity' => $activity['activity'],
                        'qty' => $activity['qty'] ?? 0,
                        'unit_cost' => $activity['unit_cost'] ?? 0,
                        'total_cost' => $activity['total_cost'] ?? 0,
                    ]);
                }

                // Save seedbed fertilizers
                foreach ($request->input('seedbed_fertilizer', []) as $fertilizer) {
                    SeedBedFertilizationFertilizers::create([
                        'seed_bed_fertilizations_id' => $seedbedFertilization->id,
                        'fertilizer_name' => $fertilizer['fertilizer_name'] ?? null,
                        'purchase_type' => $fertilizer['purchase_type'],
                        'qty' => $fertilizer['qty'] ?? 0,
                        'unit_cost' => $fertilizer['unit_cost'] ?? 0,
                        'total_cost' => $fertilizer['total_cost'] ?? 0,
                    ]);
                }
            }

            /**
             * 6. Save Crop Establishment
             */
            $cropEstablishment = CropEstablishment::create([
                'farming_data_id' => $id,
                'method' => $validated['crop_est_method'],
                'establishment_type' => $validated['crop_est_establishment_type'] ?? null,
                'is_pakyaw' => $validated['crop_est_is_pakyaw'],
                'package_total_cost' => $validated['crop_est_package_total_cost'] ?? null,
            ]);

            if (!$validated['crop_est_is_pakyaw']) {
                foreach ($request->input('crop_est_particulars', []) as $activity) {
                    CropEstablishmentParticulars::create([
                        'crop_establishment_id' => $cropEstablishment->id,
                        'activity' => $activity['activity'],
                        'qty' => $activity['qty'] ?? 0,
                        'unit_cost' => $activity['unit_cost'] ?? 0,
                        'total_cost' => $activity['total_cost'] ?? 0,
                    ]);
                }
            }

            /**
             * 7. Save Fertilizer Applications
             */
            foreach ($request->input('fertilizer_management', []) as $application) {
                $fertApp = FertilizerApplication::create([
                    'farming_data_id' => $id,
                    'label' => $application['label'],
                    'others' => $application['others'] ?? null,
                ]);
                // Save fertilizer items
                foreach ($application['items'] ?? [] as $item) {
                    FertilizerApplicationItem::create([
                        'fertilizer_application_id' => $fertApp->id,
                        'fertilizer_name' => $item['fertilizer_name'] ?? null,
                        'purchase_type' => $item['purchase_type'] ?? 'free',
                        'qty' => $item['qty'] ?? 0,
                        'unit_cost' => $item['unit_cost'] ?? 0,
                        'total_cost' => $item['total_cost'] ?? 0,
                    ]);
                }

                // Save labor: Fertilizer application
                if (!empty($application['fert_application'])) {
                    FertilizerApplicationLabor::create([
                        'fertilizer_application_id' => $fertApp->id,
                        'activity' => $application['fert_application']['activity'] ?? 'Labor: Fertilizer application',
                        'qty' => $application['fert_application']['qty'] ?? 0,
                        'unit_cost' => $application['fert_application']['unit_cost'] ?? 0,
                        'total_cost' => $application['fert_application']['total_cost'] ?? 0,
                    ]);
                }

                // Save labor: Meals and Snacks
                if (!empty($application['meals'])) {
                    FertilizerApplicationLabor::create([
                        'fertilizer_application_id' => $fertApp->id,
                        'activity' => $application['meals']['activity'] ?? 'Meals and Snacks',
                        'qty' => $application['meals']['qty'] ?? 0,
                        'unit_cost' => $application['meals']['unit_cost'] ?? 0,
                        'total_cost' => $application['meals']['total_cost'] ?? 0,
                    ]);
                }
            }

            /**
             * 8. Save Water Management
             */
            $waterManagement = WaterManagement::create([
                'farming_data_id' => $id,
                'type' => $validated['water_management_type'],
                'is_package' => $validated['water_management_is_package'] ?? false,
                'package_total_cost' => $validated['water_management_package_total_cost'] ?? null,
                'nia_total_amount' => $validated['water_management_nia_total'] ?? null,
            ]);

            // Save irrigations
            foreach ($request->input('water_irrigations', []) as $irrigation) {
                $irrigationModel = WaterIrrigation::create([
                    'water_management_id' => $waterManagement->id,
                    'label' => $irrigation['label'] ?? '',
                    'method' => $irrigation['method'] ?? 'supplementary',
                    'nia_total' => $irrigation['nia_total'] ?? null,
                ]);

                foreach ($irrigation['details'] ?? [] as $detail) {
                    WaterIrrigationDetails::create([
                        'water_irrigation_id' => $irrigationModel->id,
                        'activity' => $detail['activity'],
                        'qty' => $detail['qty'] ?? 0,
                        'unit_cost' => $detail['unit_cost'] ?? 0,
                        'total_cost' => $detail['total_cost'] ?? 0,
                    ]);
                }
            }


            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Baseline data saved successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save Baseline data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $participant_farming_data = Participant::with([
            'farming_data.land_preparation.particulars',
            'farming_data.seeds_preparation.particulars',
            'farming_data.seeds_preparation.seedVarieties',
            'farming_data.seedbed_preparation.particulars',
            'farming_data.seedbed_fertilizations.particulars',
            'farming_data.seedbed_fertilizations.fertilizers',
            'farming_data.crop_establishment.particulars',
            'farming_data.fertilizer_applications.items',
            'farming_data.fertilizer_applications.labors',
            'farming_data.water_management.irrigations.details'
        ])->findOrFail($id);

        $drySeasonData = $participant_farming_data->farming_data->firstWhere('season', 'Dry Season');
        $wetSeasonData = $participant_farming_data->farming_data->firstWhere('season', 'Wet Season');

        return view('baseline-monitoring.show', compact([
            'drySeasonData',
            'wetSeasonData',
            'participant_farming_data'
        ]));
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

    private function updateBaselineInfo(FarmingData $farmingData, array $baseline)
    {
        $farmingData->update([
            'year' => $baseline['year'],
            'farm_size_hectares' => $baseline['farm_size_hectares'],
            'method_crop_establishment' => $baseline['method_crop_establishment'],
            'number_of_bags' => $baseline['number_of_bags'],
            'avg_weight_per_bag' => $baseline['avg_weight_per_bag'],
            'price_per_kg_fresh' => $baseline['price_per_kg_fresh'],
            'price_per_kg_dry' => $baseline['price_per_kg_dry'],
            'drying_cost_per_bag' => $baseline['drying_cost_per_bag'],
        ]);
    }


    private function storeMainActivities($farmingData, $data)
    {
        $activityKeys = [
            'land_preparation',
            'seeds_preparation',
            'seedbed_preparation',
            'crop_establishment',
            'pest_management',
            'harvest',
        ];

        foreach ($activityKeys as $key) {
            if (!isset($data[$key])) continue;

            $activity = $data[$key];
            $details = $activity['details'] ?? [];

            $totalCost = $activity['total_cost'] ?? collect($details)->sum(fn($d) => floatval($d['total_cost'] ?? 0));

            $activityModel = $farmingData->activities()->create([
                'category' => $activity['category'],
                'method' => $activity['method'] ?? null,
                'is_pakyaw' => $activity['is_pakyaw'],
                'total_cost' => $totalCost,
            ]);

            foreach ($details as $detail) {
                $activityModel->details()->create([
                    'round_number' => $detail['round_number'] ?? null,
                    'activity' => $detail['activity'],
                    'qty' => $detail['qty'],
                    'unit_cost' => $detail['unit_cost'],
                    'total_cost' => $detail['total_cost'],
                ]);
            }
        }
    }

   private function storeWaterManagement(FarmingData $farmingData, array $wm)
    {
        foreach ($wm['events'] as $event) {
            $activity = $farmingData->activities()->create([
                'category' => 'Water Management',
                'method' => $event['irrigation_type'],
                'is_pakyaw' => $event['is_pakyaw'],
                'total_cost' => $event['total_cost'],
            ]);

            foreach ($event['details'] ?? [] as $detail) {
                $activity->details()->create([
                    'round_number' => $detail['round_number'] ?? $event['round_number'],
                    'activity' => $detail['activity'],
                    'qty' => $detail['qty'],
                    'unit_cost' => $detail['unit_cost'],
                    'total_cost' => $detail['total_cost'],
                ]);
            }
        }
    }


    private function storeDryingCostActivity(FarmingData $farmingData, array $baseline)
    {
        if (!empty($baseline['drying_cost_per_bag']) && $baseline['drying_cost_per_bag'] > 0) {
            $activity = $farmingData->activities()->create([
                'category' => 'Drying',
                'method' => null,
                'is_pakyaw' => false,
                'total_cost' => $baseline['drying_cost_per_bag'] * $baseline['number_of_bags'],
            ]);

            $activity->details()->create([
                'activity' => 'Drying Cost',
                'qty' => $baseline['number_of_bags'],
                'unit_cost' => $baseline['drying_cost_per_bag'],
                'total_cost' => $baseline['drying_cost_per_bag'] * $baseline['number_of_bags'],
            ]);
        }
    }


}
