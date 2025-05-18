<?php

namespace App\Http\Controllers\Main;

use App\Helpers\SeasonHelper;
use App\Models\FarmingData;
use App\Models\Participant;
use App\Models\Variety;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class BaselineMonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = Participant::with([
            'farming_data.activities.details',
            'farming_data.activities.irrigationEvents'
        ])->get();

        // return response()->json($participants);
        return view('baseline-monitoring.index', compact('participants'));
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
            // ->addColumn('season', function ($participants) {
            //     return $participants->farming_data->map(function ($data) {
            //         return "{$data->season} {$data->year_training_conducted}";
            //     })->join(', ');
            // })
            ->addColumn('wet_season', function ($participants) {
                $wetRecord = $participants->farming_data
                                ->where('season', 'Wet Season')
                                ->first();

                if (
                    $wetRecord &&
                    (
                        $wetRecord->activities->flatMap->details->isNotEmpty() ||
                        $wetRecord->activities->flatMap->irrigationEvents->isNotEmpty()
                    )
                ) {
                    return '<span class="badge bg-success">Baseline Complete</span>';
                } else {
                    return '<span class="badge bg-danger">No Baseline</span>';
                }
            })
            ->addColumn('dry_season', function ($participants) {
                $dryRecord = $participants->farming_data
                                ->where('season', 'Dry Season')
                                ->first();

                if (
                    $dryRecord &&
                    (
                        $dryRecord->activities->flatMap->details->isNotEmpty() ||
                        $dryRecord->activities->flatMap->irrigationEvents->isNotEmpty()
                    )
                ) {
                    return '<span class="badge bg-success">Baseline Complete</span>';
                } else {
                    return '<span class="badge bg-danger">No Baseline</span>';
                }
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
            'yearOptions',
            'varieties',
            'filteredFarmingData',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id, $season)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $normalizedSeason = ucwords(str_replace('-', ' ', $season));

            // 1️⃣ Retrieve Participant and Farming Data
            $participant = Participant::with('farming_data')->findOrFail($id);
            $farmingData = $participant->farming_data
                ->where('season', $normalizedSeason)
                ->first();

            if (!$farmingData) {
                return response()->json(['error' => 'Farming data not found for this season.'], 404);
            }

            // 2️⃣ Update Baseline Info
            $this->updateBaselineInfo($farmingData, $data['baseline']);

            // 3️⃣ Clear Existing Activities (details and irrigation_events are cascade deleted)
            $farmingData->activities()->delete();

            // 4️⃣ Store Regular Activities (Land Prep, Seeds Prep, etc.)
            $this->storeMainActivities($farmingData, $data);

            // 5️⃣ Store Water Management
            if (isset($data['water_management']['events'])) {
                $this->storeWaterManagement($farmingData, $data['water_management']);
            }

            // 6️⃣ Store Drying Cost (if available)
            $this->storeDryingCostActivity($farmingData, $data['baseline']);

            DB::commit();
            return response()->json(['message' => 'Updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $participant = Participant::with([
            'farming_data.activities.details',
            'farming_data.activities.irrigationEvents'
        ])->findOrFail($id);

        $drySeasonData = $participant->farming_data->firstWhere('season', 'Dry Season');
        $wetSeasonData = $participant->farming_data->firstWhere('season', 'Wet Season');

        // Organize activities by category if needed
        $drySeasonActivities = $drySeasonData ? $drySeasonData->activities->groupBy('category') : collect();
        $wetSeasonActivities = $wetSeasonData ? $wetSeasonData->activities->groupBy('category') : collect();

        // Example: Extracting Water Management from Dry Season
        $dryWaterManagement = $drySeasonActivities->get('Water Management')?->first();
        $dryIrrigationEvents = $dryWaterManagement?->irrigationEvents ?? collect();
        $dryWaterDetails = $dryWaterManagement?->details ?? collect();

         // Example: Extracting Water Management from Wet Season
        $wetWaterManagement = $wetSeasonActivities->get('Water Management')?->first();
        $wetIrrigationEvents = $wetWaterManagement?->irrigationEvents ?? collect();
        $wetWaterDetails = $wetWaterManagement?->details ?? collect();

        return view('baseline-monitoring.show', compact([
            'participant',
            'drySeasonData',
            'wetSeasonData',
            'drySeasonActivities',
            'wetSeasonActivities',
            'dryWaterManagement',
            'dryIrrigationEvents',
            'dryWaterDetails',

            'wetWaterManagement',
            'wetIrrigationEvents',
            'wetWaterDetails'
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
