<?php

namespace App\Http\Controllers\Main;

use App\Helpers\SeasonHelper;
use App\Models\Participant;
use App\Models\Variety;
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
        return view('baseline-monitoring.index');
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

                if ($wetRecord && $wetRecord->total_income !== null && $wetRecord->total_cost !== null) {
                    return '<span class="badge bg-success">Baseline Complete</span>';
                } else {
                    return '<span class="badge bg-danger">No Baseline</span>';
                }
            })
            ->addColumn('dry_season', function ($participants) {
                $dryRecord = $participants->farming_data
                                ->where('season', 'Dry Season')
                                ->first();

                if ($dryRecord && $dryRecord->total_income !== null && $dryRecord->total_cost !== null) {
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
    public function store(Request $request)
    {
        //
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

        return view('baseline-monitoring.show', compact(['participant']));
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
