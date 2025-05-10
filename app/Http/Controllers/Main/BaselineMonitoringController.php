<?php

namespace App\Http\Controllers\Main;

use App\Models\Participant;
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
                    return '<button class="btn btn-sm btn-success">
                                <i class="ri-eye-fill"></i> View Baseline
                            </button>';
                } else {
                    return '<button class="btn btn-sm btn-warning">
                                <i class="ri-add-fill"></i> Add Baseline
                            </button>';
                }
            })
            ->addColumn('dry_season', function ($participants) {
                $dryRecord = $participants->farming_data
                                ->where('season', 'Dry Season')
                                ->first();

                if ($dryRecord && $dryRecord->total_income !== null && $dryRecord->total_cost !== null) {
                    return '<button class="btn btn-sm btn-success">
                                <i class="ri-eye-fill"></i> View Baseline
                            </button>';
                } else {
                    return '<button class="btn btn-sm btn-warning">
                                <i class="ri-add-fill"></i> Add Baseline
                            </button>';
                }
            })

            ->addColumn('actions', function ($participants) {
                return '
                <a href="' . route('farmers-profile.show', $participants->id) . '" class="btn btn-sm btn-secondary editAdmin">
                    <i class="ri-eye-fill"></i> View Both
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
    public function create()
    {
        //
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
