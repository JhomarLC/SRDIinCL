<?php

namespace App\Http\Controllers\Main;

use App\Exports\TrainingEvaluationFullExport;
use App\Exports\TrainingEvaluationSingleExport;
use App\Helpers\TrainingValidationRules;
use App\Http\Controllers\Controller;
use App\Models\NotableEmployee;
use App\Models\TrainingContentEvaluation;
use App\Models\TrainingEvaluation;
use App\Models\TrainingEvent;
use App\Models\UsefulTopics;
use DB;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class TrainingEvaluationController extends Controller
{
    public function exportFullTrainingEvaluations(Request $request)
    {
        $province = $request->input('province');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        $filename = 'TrainingEvaluationReport_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new TrainingEvaluationFullExport($province, $date_from, $date_to), $filename);
    }

    public function exportTrainingEventEvaluations(string $eventId)
    {
        $event = TrainingEvent::findOrFail($eventId);

        $filename = 'TrainingEvent_' . $event->id . '_Evaluations_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new TrainingEvaluationSingleExport($event->id), $filename);
    }
    public function validateStep(Request $request)
    {
        $step = $request->input('step');
        $rules = TrainingValidationRules::rules($step);
        $messages = TrainingValidationRules::messages();

        $validated = $request->validate($rules, $messages);

        return response()->json(['success' => true]);
    }

    public function validateAllSteps(Request $request)
    {
        $steps = [
            "training-content",
            "course-management",
            "overall-evaluation",
            "personal-info"
        ];
        $messages = TrainingValidationRules::messages();

        $allErrors = [];

        foreach ($steps as $step) {
            $rules = TrainingValidationRules::rules($step);
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
    public function index(string $id)
    {
        $training_event = TrainingEvent::with([
            'evaluations.training_content_evaluation',
            'evaluations.course_management_evaluation',
            'evaluations.overall_training_assessment',
            'evaluations.training_participant_info',
            // 'evaluations.useful_topics'
        ])->findOrFail($id);

        return view('training-evaluation-management.training-evaluations.index', compact(['training_event']));
    }

    public function getIndex(string $trainingEventId)
    {
        // Get only topics for the specific speaker, eager load speaker relationship
        $training_eval = TrainingEvaluation::where('training_event_id', $trainingEventId);

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
                        $badgeClass = 'bg-secondary';
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
                    case 'Excellent':
                        $badgeClass = 'bg-success';
                        break;
                    case 'Very Good':
                        $badgeClass = 'bg-success';
                        break;
                    case 'Good':
                        $badgeClass = 'bg-secondary';
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
            ->addColumn('actions', function ($events) use ($trainingEventId)   {
                $viewButton  = ($events->status !== 'archived')
                        ? '<a href="' . route('training-evaluation-management.index', $events->id)  . '"
                                class="btn btn-sm btn-secondary">
                                <i class="ri-eye-fill"></i> View Evaluations
                            </a>'
                        : '';

                $editButton = '<a href="' . route('training-evaluation-management.edit', [$trainingEventId, $events->id]) . '" class="btn btn-sm btn-success">
                                    <i class="ri-eye-fill"></i> Update
                                </a>';

                $activateButton = ($events->status === 'archived')
                    ? '<button class="btn btn-sm btn-secondary status-unarchive"
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
            // 'evaluations.useful_topics'
        ])->findOrFail($id);

        return view('training-evaluation-management.training-evaluations.create', compact('training_event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $rules = TrainingValidationRules::rules('all');
        $messages = TrainingValidationRules::messages();

        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();

        try {
            $training_eval = TrainingEvaluation::create([
                'training_event_id' => $id,
            ]);

            // Step 1: Training Content Evaluation
            $content_evaluation = $training_eval->training_content_evaluation()->create([
                'objective_score' => $validated['objective_score'],
                'relevance_score' => $validated['relevance_score'],
                'content_completeness_score' => $validated['content_completeness_score'],
                'lecture_hands_on_score' => $validated['lecture_hands_on_score'],
                'sequence_score' => $validated['sequence_score'],
                'duration_score' => $validated['duration_score'],
                'assessment_method_score' => $validated['assessment_method_score'],

                'objective_comment' => $validated['objective_comment'] ?? null,
                'relevance_comment' => $validated['relevance_comment'] ?? null,
                'content_completeness_comment' => $validated['content_completeness_comment'] ?? null,
                'lecture_hands_on_comment' => $validated['lecture_hands_on_comment'] ?? null,
                'sequence_comment' => $validated['sequence_comment'] ?? null,
                'duration_comment' => $validated['duration_comment'] ?? null,
                'assessment_method_comment' => $validated['assessment_method_comment'] ?? null,

                'low_score_comment_1' => $validated['low_score_comment_1'] ?? null,
            ]);

            if ($request->filled('three_topics')) {
                $foodRestrictions = explode(',', $request->input('three_topics'));
                foreach ($foodRestrictions as $item) {
                    UsefulTopics::create([
                        'training_content_evaluation_id' => $content_evaluation->id,
                        'topic_name' => trim($item),
                    ]);
                }
            }

            // Step 2: Course Management Evaluation
            $training_eval->course_management_evaluation()->create([
                'coordination_score' => $validated['coordination_score'],
                'time_management_score' => $validated['time_management_score'],
                'speaker_quality_score' => $validated['speaker_quality_score'],
                'facilitators_score' => $validated['facilitators_score'],
                'support_staff_score' => $validated['support_staff_score'],
                'materials_score' => $validated['materials_score'],
                'facility_score' => $validated['facility_score'],
                'accommodation_score' => $validated['accommodation_score'],
                'food_quality_score' => $validated['food_quality_score'],
                'transportation_score' => $validated['transportation_score'],
                'overall_management_score' => $validated['overall_management_score'],

                'coordination_comment' => $validated['coordination_comment'] ?? null,
                'time_management_comment' => $validated['time_management_comment'] ?? null,
                'speaker_quality_comment' => $validated['speaker_quality_comment'] ?? null,
                'facilitators_comment' => $validated['facilitators_comment'] ?? null,
                'support_staff_comment' => $validated['support_staff_comment'] ?? null,
                'materials_comment' => $validated['materials_comment'] ?? null,
                'facility_comment' => $validated['facility_comment'] ?? null,
                'accommodation_comment' => $validated['accommodation_comment'] ?? null,
                'food_quality_comment' => $validated['food_quality_comment'] ?? null,
                'transportation_comment' => $validated['transportation_comment'] ?? null,
                'overall_management_comment' => $validated['overall_management_comment'] ?? null,

                'low_score_comment_2' => $validated['low_score_comment_2'] ?? null,
            ]);

            // Step 3: Overall Training Assessment
            $assessment = $training_eval->overall_training_assessment()->create([
                'goal_achievement' => $validated['goal_achievement'],
                'overall_quality' => $validated['overall_quality'],
                'additional_feedback_or_suggestions' => $validated['additional_feedback_or_suggestions'] ?? null,
                'recommend_training' => $validated['recommend_training'],
                'recommendation_reason' => $validated['recommendation_reason'] ?? null,
                'preferred_future_trainings' => $validated['preferred_future_trainings'] ?? null,
            ]);

             // 2. Save trainings
             foreach ($validated['employee_name'] as $index => $employee_name) {
                $employee_reason = $validated['employee_reason'][$index] ?? null;

                // ✅ Skip if all fields are empty/null
                if (empty($employee_name) && empty($employee_reason)) {
                    continue;
                }
                // 🧠 Optional: only require `title` at minimum
                NotableEmployee::create([
                    'overall_training_assessment_id' => $assessment->id,
                    'employee_name' => $employee_name,
                    'employee_reason' => $employee_reason,
                ]);
            }

            // Step 4: Training Participant Info
            $training_eval->training_participant_info()->create([
                'first_name' => $validated['first_name'] ?? null,
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'] ?? null,
                'suffix' => $validated['suffix'] ?? null,
                'age_group' => $validated['age_group'],
                'sex' => $validated['sex'],
                'province_code' => $validated['province_code'],
                'primary_sector' => $validated['primary_sector'],
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Training evaluations created successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create new evaluation.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
    public function edit(string $trainingEventId, string $trainingEvalId)
    {
        $training_event = TrainingEvent::with([
            'evaluations' => function ($query) use ($trainingEvalId) {
                $query->where('id', $trainingEvalId)
                    ->with([
                        'training_content_evaluation',
                        'course_management_evaluation',
                        'overall_training_assessment',
                        'training_participant_info',
                        // 'useful_topics' // if you want to load this too
                    ]);
            }
        ])->findOrFail($trainingEventId);

        $evaluation = TrainingEvaluation::with([
            'training_content_evaluation',
            'course_management_evaluation',
            'overall_training_assessment',
            'overall_training_assessment.notable_employees',
            'training_participant_info',
        ])->where('training_event_id', $trainingEventId)
          ->where('id', $trainingEvalId)
          ->firstOrFail();

        $trainingContent = $evaluation->training_content_evaluation;
        $selectedTopics = $trainingContent?->useful_topics?->pluck('topic_name')->toArray() ?? [];

        return view('training-evaluation-management.training-evaluations.update', compact(['training_event', 'evaluation', 'selectedTopics']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $trainingEventId, string $trainingEvalId)
    {
        $rules = TrainingValidationRules::rules('all');
        $messages = TrainingValidationRules::messages();
        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();

        try {
            $training_eval = TrainingEvaluation::with([
                'training_content_evaluation.useful_topics',
                'course_management_evaluation',
                'overall_training_assessment.notable_employees',
                'training_participant_info',
            ])->where('training_event_id', $trainingEventId)
                ->where('id', $trainingEvalId)
                ->firstOrFail();

            // Step 1: Update Training Content Evaluation
            $content_eval = $training_eval->training_content_evaluation;
            $content_eval->update([
                'objective_score' => $validated['objective_score'],
                'relevance_score' => $validated['relevance_score'],
                'content_completeness_score' => $validated['content_completeness_score'],
                'lecture_hands_on_score' => $validated['lecture_hands_on_score'],
                'sequence_score' => $validated['sequence_score'],
                'duration_score' => $validated['duration_score'],
                'assessment_method_score' => $validated['assessment_method_score'],

                'objective_comment' => $validated['objective_comment'] ?? null,
                'relevance_comment' => $validated['relevance_comment'] ?? null,
                'content_completeness_comment' => $validated['content_completeness_comment'] ?? null,
                'lecture_hands_on_comment' => $validated['lecture_hands_on_comment'] ?? null,
                'sequence_comment' => $validated['sequence_comment'] ?? null,
                'duration_comment' => $validated['duration_comment'] ?? null,
                'assessment_method_comment' => $validated['assessment_method_comment'] ?? null,

                'low_score_comment_1' => $validated['low_score_comment_1'] ?? null,
            ]);

            // Replace useful topics
            $content_eval->useful_topics()->delete();

            if ($request->filled('three_topics')) {
                $topics = explode(',', $request->input('three_topics'));

                foreach ($topics as $topic) {
                    UsefulTopics::create([
                        'training_content_evaluation_id' => $content_eval->id,
                        'topic_name' => trim($topic),
                    ]);
                }
            }

            // Step 2: Update Course Management Evaluation
            $training_eval->course_management_evaluation->update([
                'coordination_score' => $validated['coordination_score'],
                'time_management_score' => $validated['time_management_score'],
                'speaker_quality_score' => $validated['speaker_quality_score'],
                'facilitators_score' => $validated['facilitators_score'],
                'support_staff_score' => $validated['support_staff_score'],
                'materials_score' => $validated['materials_score'],
                'facility_score' => $validated['facility_score'],
                'accommodation_score' => $validated['accommodation_score'],
                'food_quality_score' => $validated['food_quality_score'],
                'transportation_score' => $validated['transportation_score'],
                'overall_management_score' => $validated['overall_management_score'],

                'coordination_comment' => $validated['coordination_comment'] ?? null,
                'time_management_comment' => $validated['time_management_comment'] ?? null,
                'speaker_quality_comment' => $validated['speaker_quality_comment'] ?? null,
                'facilitators_comment' => $validated['facilitators_comment'] ?? null,
                'support_staff_comment' => $validated['support_staff_comment'] ?? null,
                'materials_comment' => $validated['materials_comment'] ?? null,
                'facility_comment' => $validated['facility_comment'] ?? null,
                'accommodation_comment' => $validated['accommodation_comment'] ?? null,
                'food_quality_comment' => $validated['food_quality_comment'] ?? null,
                'transportation_comment' => $validated['transportation_comment'] ?? null,
                'overall_management_comment' => $validated['overall_management_comment'] ?? null,

                'low_score_comment_2' => $validated['low_score_comment_2'] ?? null,
            ]);

            // Step 3: Update Overall Training Assessment
            $assessment = $training_eval->overall_training_assessment;
            $assessment->update([
                'goal_achievement' => $validated['goal_achievement'],
                'overall_quality' => $validated['overall_quality'],
                'additional_feedback_or_suggestions' => $validated['additional_feedback_or_suggestions'] ?? null,
                'recommend_training' => $validated['recommend_training'],
                'recommendation_reason' => $validated['recommendation_reason'] ?? null,
                'preferred_future_trainings' => $validated['preferred_future_trainings'] ?? null,
            ]);

            // Replace Notable Employees
            $assessment->notable_employees()->delete();
            foreach ($validated['employee_name'] as $index => $employee_name) {
                $employee_reason = $validated['employee_reason'][$index] ?? null;
                if (empty($employee_name) && empty($employee_reason)) {
                    continue;
                }

                NotableEmployee::create([
                    'overall_training_assessment_id' => $assessment->id,
                    'employee_name' => $employee_name,
                    'employee_reason' => $employee_reason,
                ]);
            }

            // Step 4: Update Training Participant Info
            $training_eval->training_participant_info->update([
                'first_name' => $validated['first_name'] ?? null,
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'] ?? null,
                'suffix' => $validated['suffix'] ?? null,
                'age_group' => $validated['age_group'],
                'sex' => $validated['sex'],
                'province_code' => $validated['province_code'],
                'primary_sector' => $validated['primary_sector'],
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Training evaluation updated successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update the evaluation.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function archive(string $eventId, string $evalId)
    {
        $eval = TrainingEvaluation::where('id', $evalId)
                    ->where('training_event_id', $eventId)
                    ->firstOrFail();

        if ($eval->status === 'archived') {
            return response()->json([
                'status' => 'error',
                'message' => 'This training evaluation is already archived.'
            ]);
        }

        $eval->update(['status' => 'archived']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($eval)
            ->event('training_evaluation_archived')
            ->withProperties([
                'status' => [
                    'old' => 'active',
                    'new' => 'archived'
                ],
            ])
            ->log("Training Evaluation has been archived.");

        return response()->json([
            'status' => 'success',
            'message' => 'Training Evaluation archived successfully!',
            'eval' => $eval
        ]);
    }


    public function unarchive(string $eventId, string $evalId)
    {
        $eval = TrainingEvaluation::where('id', $evalId)
                             ->where('training_event_id', $eventId)
                             ->firstOrFail();

        if ($eval->status === 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'This training evaluation is already unarchived.'
            ]);
        }

        $eval->update(['status' => 'active']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($eval)
            ->event('training_evaluation_unarchived')
            ->withProperties([
                'status' => [
                    'old' => 'archived',
                    'new' => 'active'
                ],
            ])
            ->log("Training Evaluation has been unarchive.");

        return response()->json([
            'status' => 'success',
            'message' => 'Training Evaluation unarchived successfully!',
            'eval' => $eval
        ]);
    }
}
