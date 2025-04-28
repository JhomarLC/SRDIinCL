<?php

namespace App\Http\Controllers\Main;

use App\Helpers\EvaluationValidationRules;
use App\Http\Controllers\Controller;
use App\Models\Speaker;
use App\Models\SpeakerEvaluation;
use App\Models\SpeakerEvaluationsInfo;
use App\Models\SpeakerTopic;
use DB;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SpeakerEvaluationController extends Controller
{
    public function validateStep(Request $request)
    {
        $step = $request->input('step');
        $rules = EvaluationValidationRules::rules($step);
        $messages = EvaluationValidationRules::messages();

        $validated = $request->validate($rules, $messages);

        return response()->json(['success' => true]);
    }

    public function validateAllSteps(Request $request)
    {
        $steps = ['speaker-evaluation', 'evaluation-personal-info'];
        $messages = EvaluationValidationRules::messages();

        $allErrors = [];

        foreach ($steps as $step) {
            $rules = EvaluationValidationRules::rules($step);
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
    public function index(string $speakerId, string $topicId)
    {
        $speaker = Speaker::findOrFail($speakerId);
        $speaker_topic = SpeakerTopic::with(['speaker', 'speaker_evaluation'])
                    ->where('speaker_id', $speakerId)
                    ->where('id', $topicId) // example of another where condition
                    ->firstOrFail(); // returns a single model, not a collection

        $label = SpeakerTopic::getTopicLabel($speaker_topic->topic_discussed);

        // 🧠 Calculate average overall score across all evaluations
        $average_overall_score = round(
            $speaker_topic->speaker_evaluation->where('status', 'active')->avg(function ($evaluation) {
                return $evaluation->overall_score;
            }),
            2
        );

        return view('speaker-management.speaker-topics.speaker-evaluations.index',
            compact(['speaker', 'speaker_topic', 'label', 'average_overall_score']));
    }

    public function getIndex(string $speakerId, string $topicId)
    {
        // Get only topics for the specific speaker, eager load speaker relationship
        $speaker_eval = SpeakerEvaluation::with('speaker_topic')
                        ->where('speaker_topic_id', $topicId)->get();

        return DataTables::of($speaker_eval)
            ->addColumn('full_name', function ($eval) {
                return $eval->speaker_evaluation_info->full_name;
            })
            ->addColumn('actions', function ($eval) use ($speakerId, $topicId)  {
                $viewButton  = ($eval->status !== 'archived')
                            ? '<a href=""
                                    class="btn btn-sm btn-secondary">
                                    <i class="ri-eye-fill"></i> View Evaluation
                                </a>'
                            : '';
                $editButton = '<a href="' . route('speaker-eval.edit', [$speakerId, $topicId, $eval->id]) . '" class="btn btn-sm btn-success">
                                    <i class="ri-eye-fill"></i> Update
                                </a>';

                $activateButton = ($eval->status === 'archived')
                    ? '<button class="btn btn-sm btn-secondary status-unarchive"
                            data-id="' . $eval->id . '">
                            <i class="ri-service-fill"></i>
                            Unarchive
                        </button>'
                    : '';

                $deactivateButton = ($eval->status === 'active')
                ? '<button class="btn btn-sm btn-danger status-archive"
                        data-id="' . $eval->id . '">
                        <i class="ri-archive-fill"></i>
                        Archive
                    </button>'
                : '';

                return  $viewButton . ' ' . ($eval->status === 'active' && $editButton ? $editButton : "") . ' ' . $activateButton . ' ' . $deactivateButton;
            })
            ->addColumn('overall_score', function ($eval)  {
                return $eval->overall_score . " (" . scoreLabel($eval->overall_score) . ")";
            })
            ->editColumn('status', function ($eval) {
                return $eval->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Archived</span>';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $speakerId, string $topicId)
    {
        $speaker = Speaker::findOrFail($speakerId);
        $speaker_topic = SpeakerTopic::with(['speaker', 'speaker_evaluation'])
                    ->where('speaker_id', $speakerId)
                    ->where('id', $topicId) // example of another where condition
                    ->firstOrFail(); // returns a single model, not a collection
        $label = SpeakerTopic::getTopicLabel($speaker_topic->topic_discussed);

        // 🧠 Calculate average overall score across all evaluations
        $average_overall_score = round(
            $speaker_topic->speaker_evaluation->avg(function ($evaluation) {
                return $evaluation->overall_score;
            }),
            2
        );
        return view('speaker-management.speaker-topics.speaker-evaluations.create',
        compact(['speaker', 'speaker_topic', 'label', 'average_overall_score']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $speakerId, string $topicId)
    {
        //
        $rules = EvaluationValidationRules::rules('all');
        $messages = EvaluationValidationRules::messages();

        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            // 1. Save participant
            $evaluation  = SpeakerEvaluation::create([
                'speaker_topic_id' => $topicId,

                'knowledge_score' => $validated['knowledge_score'],
                'teaching_method_score' => $validated['teaching_method_score'],
                'audiovisual_score' => $validated['audiovisual_score'],
                'clarity_score' => $validated['clarity_score'],
                'question_handling_score' => $validated['question_handling_score'],
                'audience_connection_score' => $validated['audience_connection_score'],
                'content_relevance_score' => $validated['content_relevance_score'],
                'goal_achievement_score' => $validated['goal_achievement_score'],

                'knowledge_score_comment' => $validated['knowledge_score_comment'] ?? null,
                'teaching_method_comment' => $validated['teaching_method_comment'] ?? null,
                'audiovisual_comment' => $validated['audiovisual_comment'] ?? null,
                'clarity_comment' => $validated['clarity_comment'] ?? null,
                'question_handling_comment' => $validated['question_handling_comment'] ?? null,
                'audience_connection_comment' => $validated['audience_connection_comment'] ?? null,
                'content_relevance_comment' => $validated['content_relevance_comment'] ?? null,
                'goal_achievement_comment' => $validated['goal_achievement_comment'] ?? null,

                'additional_feedback' => $validated['additional_feedback'] ?? null,
            ]);

            $info = new SpeakerEvaluationsInfo([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'suffix' => $validated['suffix'] ?? null,
                'age_group' => $validated['age_group'],
                'is_pwd' => $validated['is_pwd'],
                'disability_type' => $validated['disability_type'] ?? null,
                'is_indigenous' => $validated['is_indigenous'],
                'tribe_name' => $validated['tribe_name'] ?? null,
                'gender' => $validated['gender'],
                'province_code' => $validated['province_code'],
                'primary_sector' => $validated['primary_sector'],
            ]);

            // Associate and save the info
            $evaluation->speaker_evaluation_info()->save($info);

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Speaker evaluations created successfully!']);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Failed to create new evaluation.', 'error' => $e->getMessage()], 500);
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
    public function edit(string $speakerId, string $topicId, string $evalId)
    {
        $speaker = Speaker::findOrFail($speakerId);
        $speaker_topic = SpeakerTopic::with(['speaker', 'speaker_evaluation'])
                                    ->where('speaker_id', $speakerId)
                                    ->where('id', $topicId) // example of another where condition
                                    ->firstOrFail(); // returns a single model, not a collection
        $evaluation = SpeakerEvaluation::with(['speaker_evaluation_info'])
                                        ->where('id', $evalId)
                                        ->where('speaker_topic_id', $topicId)
                                        ->firstOrFail();

        return view('speaker-management.speaker-topics.speaker-evaluations.update', compact(['speaker', 'speaker_topic', 'evaluation']));
    }

   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $speakerId, string $topicId, string $evalId)
    {

               // Step 1: Validate the request
        $validated = $request->validate(
            EvaluationValidationRules::rules('all'),
            EvaluationValidationRules::messages()
        );

        DB::beginTransaction();
        try {
            // 1. Find the participant
            $evaluation = SpeakerEvaluation::where('id', $evalId)
                    ->where('speaker_topic_id', $topicId)
                    ->firstOrFail();

            // 2. Update participant data
            $evaluation->update([
                'knowledge_score' => $validated['knowledge_score'],
                'teaching_method_score' => $validated['teaching_method_score'],
                'audiovisual_score' => $validated['audiovisual_score'],
                'clarity_score' => $validated['clarity_score'],
                'question_handling_score' => $validated['question_handling_score'],
                'audience_connection_score' => $validated['audience_connection_score'],
                'content_relevance_score' => $validated['content_relevance_score'],
                'goal_achievement_score' => $validated['goal_achievement_score'],

                'knowledge_score_comment' => $validated['knowledge_score_comment'] ?? null,
                'teaching_method_comment' => $validated['teaching_method_comment'] ?? null,
                'audiovisual_comment' => $validated['audiovisual_comment'] ?? null,
                'clarity_comment' => $validated['clarity_comment'] ?? null,
                'question_handling_comment' => $validated['question_handling_comment'] ?? null,
                'audience_connection_comment' => $validated['audience_connection_comment'] ?? null,
                'content_relevance_comment' => $validated['content_relevance_comment'] ?? null,
                'goal_achievement_comment' => $validated['goal_achievement_comment'] ?? null,

                'additional_feedback' => $validated['additional_feedback'] ?? null,
            ]);


            // 6. Update Emergency Contact
            $evaluation->speaker_evaluation_info()->update([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'suffix' => $validated['suffix'] ?? null,
                'age_group' => $validated['age_group'],
                'is_pwd' => $validated['is_pwd'],
                'disability_type' => $validated['disability_type'] ?? null,
                'is_indigenous' => $validated['is_indigenous'],
                'tribe_name' => $validated['tribe_name'] ?? null,
                'gender' => $validated['gender'],
                'province_code' => $validated['province_code'],
                'primary_sector' => $validated['primary_sector'],
            ]);

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Speaker Evaluation updated successfully!']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Failed to update Speaker Evaluation.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function archive(string $speakerId, string $topicId, string $evalId)
    {
        $eval = SpeakerEvaluation::where('id', $evalId)
                             ->where('speaker_topic_id', $topicId)
                             ->with('speaker_topic')
                             ->firstOrFail();

        if ($eval->status === 'archived') {
            return response()->json([
                'status' => 'error',
                'message' => 'This evaluation is already archived.'
            ]);
        }

        $eval->update(['status' => 'archived']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($eval)
            ->event('speaker_evaluation_archived')
            ->withProperties([
                'status' => [
                    'old' => 'active',
                    'new' => 'archived'
                ],
            ])
            ->log("Speaker Evaluation with overall score with {$eval->overall_score} has been archived.");

        return response()->json([
            'status' => 'success',
            'message' => 'Speaker Evaluation archived successfully!',
            'eval' => $eval
        ]);
    }


    public function unarchive(string $speakerId, string $topicId, string $evalId)
    {
        $eval = SpeakerEvaluation::where('id', $evalId)
                             ->where('speaker_topic_id', $topicId)
                             ->with('speaker_topic')
                             ->firstOrFail();

        if ($eval->status === 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'This evaluation is already unarchived.'
            ]);
        }

        $eval->update(['status' => 'active']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($eval)
            ->event('speaker_evaluation_unarchived')
            ->withProperties([
                'status' => [
                    'old' => 'archived',
                    'new' => 'active'
                ],
            ])
            ->log("Speaker Evaluation with overall score with {$eval->overall_score} has been unarchive.");

        return response()->json([
            'status' => 'success',
            'message' => 'Speaker Evaluation unarchived successfully!',
            'eval' => $eval
        ]);
    }
}
