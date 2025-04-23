<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingEvent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TrainingEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.training-evaluation-management.index');
    }


    public function getIndex()
    {
        // Get only topics for the specific speaker, eager load speaker relationship
        $training_events = TrainingEvent::all();

        return DataTables::of($training_events)
            ->addColumn('actions', function ($events)   {
                $viewButton  = ($events->status !== 'archived')
                        ? '<a href="' . route('training-evaluation-management.index', $events->id)  . '"
                                class="btn btn-sm btn-secondary">
                                <i class="ri-eye-fill"></i> View Evaluations
                            </a>'
                        : '';

                $editButton = '<button class="btn btn-sm btn-success editTrainingEvent"
                                    data-id="' . $events->id . '"
                                    data-training_title="' . $events->training_title . '"
                                    data-training_date="' . $events->training_date . '"
                                    data-province="' . $events->province_code . '"
                                    data-municipality="' .$events->municipality_code . '"
                                    data-barangay="' . $events->barangay_code . '">
                                    <i class="ri-edit-fill"></i> Update
                                </button>';

                $activateButton = ($events->status === 'archived')
                    ? '<button class="btn btn-sm btn-secondary status-activate"
                            data-id="' . $events->id . '">
                            <i class="ri-service-fill"></i>
                            Unarchive
                        </button>'
                    : '';

                $deactivateButton = ($events->status === 'active')
                ? '<button class="btn btn-sm btn-danger status-archive"
                        data-id="' . $events->id . '">
                        <i class="ri-archive-fill"></i>
                        Archive
                    </button>'
                : '';

                return $viewButton . ' ' . ($events->status === 'active' && $editButton ? $editButton : "") . ' ' . $activateButton . ' ' . $deactivateButton;
            })
            ->editColumn('training_formatted_date', function ($events) {
                return $events->formatted_training_date;
            })
            ->addColumn('training_location', function ($events) {
                return $events->full_address;
            })
            ->addColumn('most_common_goal_achievement', function ($events) {
                $output = '';
                $goals = explode(',', $events->most_common_goal_achievement);

                foreach ($goals as $goal) {
                    $goal = trim($goal);
                    $class = match($goal) {
                        'Achieve' => 'bg-success',
                        'Partially Achieved' => 'bg-warning text-dark',
                        'Not Achieved' => 'bg-danger',
                        default => 'bg-secondary'
                    };

                    $output .= '<span class="badge ' . $class . '">' . $goal . '</span> ';
                }

                return trim($output);
            })
            ->addColumn('most_common_overall_quality', function ($events) {
                $output = '';
                $qualities = explode(',', $events->most_common_overall_quality);

                foreach ($qualities as $quality) {
                    $quality = trim($quality);
                    $class = match($quality) {
                        'Very Good' => 'bg-success',
                        'Good' => 'bg-primary',
                        'Fair' => 'bg-warning text-dark',
                        'Poor' => 'bg-danger',
                        default => 'bg-secondary'
                    };

                    $output .= '<span class="badge ' . $class . '">' . $quality . '</span> ';
                }

                return trim($output);
            })
            ->editColumn('status', function ($events) {
                return $events->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Archived</span>';
            })
            ->rawColumns(['status', 'most_common_goal_achievement', 'most_common_overall_quality', 'actions'])
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
        $validatedData = $request->validate([
            'training_title' => 'required|string|max:255',
            'training_date' => 'required|string|max:255',
            'province_code' => 'required|string',
            'municipality_code' => 'required|string',
            'barangay_code' => 'required|string',
        ]);

        $training_event = TrainingEvent::create([
            'training_date' => $validatedData['training_date'],
            'training_title' => $validatedData['training_title'],
            'province_code' => $validatedData['province_code'],
            'municipality_code' => $validatedData['municipality_code'],
            'barangay_code' => $validatedData['barangay_code'],
        ]);

        // Log a single activity for admin
        activity()
            ->causedBy(auth()->user())
            ->performedOn($training_event)
            ->event('training_event_create')
            ->withProperties([
                'admin' => $training_event->only([
                    'training_title',
                    'training_date',
                    'province_code',
                    'municipality_code',
                    'barangay_code'
                ]),
            ])
        ->log("New training event {$training_event->full_addresss} - {$training_event->fromatted_training_date} created");

        return response()->json(['status' => 'success', 'message' => 'Training event created successfully!', 'training_event' => $training_event]);
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
        $validatedData = $request->validate([
            'training_title' => 'required|string|max:255',
            'training_date' => 'required|string|max:255',
            'province_code' => 'required|string',
            'municipality_code' => 'required|string',
            'barangay_code' => 'required|string',
        ]);

        // You can optionally check if the topic really belongs to the speaker
        $training_event = TrainingEvent::findOrFail($id);

        $originalData = $training_event->only(['training_title', 'training_date']);

        $training_event->update([
            'training_title' => $validatedData['training_title'],
            'training_date' => $validatedData['training_date'],
            'province_code' => $validatedData['province_code'],
            'municipality_code' => $validatedData['municipality_code'],
            'barangay_code' => $validatedData['barangay_code'],
        ]);

        $changes = [];
        foreach ($originalData as $key => $value) {
            if ($value !== $training_event->$key) {
                $changes['topic'][$key] = [
                    'old' => $value,
                    'new' => $training_event->$key,
                ];
            }
        }

        if (!empty($changes)) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($training_event)
                ->event('training_event_updated')
                ->withProperties($changes)
                ->log("Training event updated for {$training_event->training_title}.");
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Training event updated successfully!',
            'training_event' => $training_event
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
