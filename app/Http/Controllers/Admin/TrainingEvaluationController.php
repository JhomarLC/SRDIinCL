<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TrainingValidationRules;
use App\Http\Controllers\Controller;
use App\Models\TrainingEvaluation;
use App\Models\TrainingEvent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TrainingEvaluationController extends Controller
{
    public function validateStep(Request $request)
    {
        $step = $request->input('step');
        $rules = TrainingValidationRules::rules($step);
        $messages = TrainingValidationRules::messages();

        $validated = $request->validate($rules, $messages);

        return response()->json(['success' => true]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $training_event = TrainingEvent::with([
            'evaluations.training_content_evaluation',
            'evaluations.course_management_evaluation',
            'evaluations.overall_training_assessment',
            'evaluations.training_participant_info',
            'evaluations.useful_topics'
        ])->findOrFail($id);

        return view('admin.training-evaluation-management.training-evaluations.index', compact(['training_event']));
    }

    public function getIndex(string $id)
    {
        // Get only topics for the specific speaker, eager load speaker relationship
        $training_eval = TrainingEvaluation::where('training_event_id', $id);

        return DataTables::of($training_eval)
            ->addColumn('training_content_evaluation', function ($events) {
                $contentEval = $events->training_content_evaluation;

                if (!$contentEval) {
                    return 'N/A';
                }

                $overall_score = $contentEval->overall_score;

                return $overall_score . ' (' . scoreLabel($overall_score) . ')';
            })
            ->addColumn('course_management_evaluation', function ($events) {
                $cmEval = $events->course_management_evaluation;

                if (!$cmEval) {
                    return 'N/A';
                }

                $overall_score = $cmEval->overall_score;

                return $overall_score . ' (' . scoreLabel($overall_score) . ')';
            })
            ->addColumn('goal_achievement', function ($events) {
                $goal_achievement = optional($events->overall_training_assessment)->goal_achievement;

                if (!$goal_achievement) {
                    return '<span class="badge bg-secondary">N/A</span>';
                }

                switch ($goal_achievement) {
                    case 'Achieve':
                        $badgeClass = 'bg-success';
                        break;
                    case 'Partially Achieved':
                        $badgeClass = 'bg-warning text-dark';
                        break;
                    case 'Not Achieved':
                        $badgeClass = 'bg-danger';
                        break;
                    default:
                        $badgeClass = 'bg-secondary';
                        break;
                }

                return '<span class="badge ' . $badgeClass . '">' . $goal_achievement . '</span>';
            })
            ->addColumn('overall_quality', function ($events) {
                $overall_quality = optional($events->overall_training_assessment)->overall_quality;

                if (!$overall_quality) {
                    return '<span class="badge bg-secondary">N/A</span>';
                }

                switch ($overall_quality) {
                    case 'Very Good':
                        $badgeClass = 'bg-success';
                        break;
                    case 'Good':
                        $badgeClass = 'bg-primary';
                        break;
                    case 'Fair':
                        $badgeClass = 'bg-warning text-dark';
                        break;
                    case 'Poor':
                        $badgeClass = 'bg-danger';
                        break;
                    default:
                        $badgeClass = 'bg-secondary';
                        break;
                }

                return '<span class="badge ' . $badgeClass . '">' . $overall_quality . '</span>';
            })
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
            ->editColumn('status', function ($eval) {
                return $eval->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Archived</span>';
            })
            ->rawColumns(['status', 'goal_achievement', 'overall_quality', 'actions'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $training_event = TrainingEvent::with([
            'evaluations.training_content_evaluation',
            'evaluations.course_management_evaluation',
            'evaluations.overall_training_assessment',
            'evaluations.training_participant_info',
            'evaluations.useful_topics'
        ])->findOrFail($id);

        return view('admin.training-evaluation-management.training-evaluations.create', compact('training_event'));
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
