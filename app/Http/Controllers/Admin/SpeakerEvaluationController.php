<?php

namespace App\Http\Controllers\Admin;

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
        if ($step == 'speaker-evaluation') {
            $rules = [
                'knowledge_score' => 'required',
                'teaching_method_score' => 'required',
                'audiovisual_score' => 'required',
                'clarity_score' => 'required',
                'question_handling_score' => 'required',
                'audience_connection_score' => 'required',
                'content_relevance_score' => 'required',
                'goal_achievement_score' => 'required',
            ];

            $messages = [
                'knowledge_score.required' => 'Please provide a score for knowledge.',
                'teaching_method_score.required' => 'Please provide a score for teaching method.',
                'audiovisual_score.required' => 'Please provide a score for audiovisual materials.',
                'clarity_score.required' => 'Please provide a score for clarity.',
                'question_handling_score.required' => 'Please provide a score for question handling.',
                'audience_connection_score.required' => 'Please provide a score for audience connection.',
                'content_relevance_score.required' => 'Please provide a score for content relevance.',
                'goal_achievement_score.required' => 'Please provide a score for goal achievement.',
            ];
        }
        if ($step === 'evaluation-personal-info') {
            $rules = [
                'first_name' => 'nullable|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:50',
                'age_group' => 'required|string',
                'is_pwd' => 'required|boolean',
                'disability_type' => 'nullable|required_if:is_pwd,1|string',
                'is_indigenous' => 'required|boolean',
                'tribe_name' => 'nullable|required_if:is_indigenous,1|string',
                'gender' => 'required|string',
                'province_code' => 'required|string',
                'primary_sector' => 'required|in:Farmer/Seed Grower,Extension Worker,Researcher,Educator,Student,Policy Maker,Media,Industry Player,Others',
            ];
            $messages = [
                'tribe_name.required_if' => 'Please enter tribe name if the person is indigenous.',
                'disability_type.required_if' => 'Please select type of disability_type if the person is PWD.',
                'zip_code.number' => 'The ZIP code must be a valid number.',
            ];
        }
        $validated = $request->validate($rules, $messages);

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

        return view('admin.speaker-management.speaker-topics.speaker-evaluations.index',
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
            ->addColumn('actions', function ($eval)  {
                $viewButton  = ($eval->status !== 'archived')
                            ? '<a href=""
                                    class="btn btn-sm btn-secondary">
                                    <i class="ri-eye-fill"></i> View Evaluation
                                </a>'
                            : '';
                $editButton = '<button class="btn btn-sm btn-success editTopic"
                                    data-id="' . $eval->id . '"
                                    data-topic_discussed="' . $eval->topic_discussed . '"
                                    data-topic_date="' . $eval->topic_date . '">
                                    <i class="ri-edit-fill"></i> Update
                                </button>';

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
        return view('admin.speaker-management.speaker-topics.speaker-evaluations.create',
        compact(['speaker', 'speaker_topic', 'label', 'average_overall_score']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $speakerId, string $topicId)
    {
        //
        $rules = [
            'knowledge_score' => 'required',
            'teaching_method_score' => 'required',
            'audiovisual_score' => 'required',
            'clarity_score' => 'required',
            'question_handling_score' => 'required',
            'audience_connection_score' => 'required',
            'content_relevance_score' => 'required',
            'goal_achievement_score' => 'required',

            'knowledge_score_comment' => 'nullable',
            'teaching_method_comment' => 'nullable',
            'audiovisual_comment' => 'nullable',
            'clarity_comment' => 'nullable',
            'question_handling_comment' => 'nullable',
            'audience_connection_comment' => 'nullable',
            'content_relevance_comment' => 'nullable',
            'goal_achievement_comment' => 'nullable',
            'additional_feedback' => 'nullable',

            'first_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'age_group' => 'required|string',
            'is_pwd' => 'required|boolean',
            'disability_type' => 'nullable|required_if:is_pwd,1|string',
            'is_indigenous' => 'required|boolean',
            'tribe_name' => 'nullable|required_if:is_indigenous,1|string',
            'gender' => 'required|string',
            'province_code' => 'required|string',
            'primary_sector' => 'required|in:Farmer/Seed Grower,Extension Worker,Researcher,Educator,Student,Policy Maker,Media,Industry Player,Others',
        ];

        $messages = [
            'knowledge_score.required' => 'Please provide a score for knowledge.',
            'teaching_method_score.required' => 'Please provide a score for teaching method.',
            'audiovisual_score.required' => 'Please provide a score for audiovisual materials.',
            'clarity_score.required' => 'Please provide a score for clarity.',
            'question_handling_score.required' => 'Please provide a score for question handling.',
            'audience_connection_score.required' => 'Please provide a score for audience connection.',
            'content_relevance_score.required' => 'Please provide a score for content relevance.',
            'goal_achievement_score.required' => 'Please provide a score for goal achievement.',

            'tribe_name.required_if' => 'Please enter tribe name if the person is indigenous.',
            'disability_type.required_if' => 'Please select type of disability_type if the person is PWD.',
        ];

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
            ->event('topic_archived')
            ->withProperties([
                'status' => [
                    'old' => 'active',
                    'new' => 'archived'
                ],
            ])
            ->log("Evaluation with overall score with {$eval->overall_score} has been archived.");

        return response()->json([
            'status' => 'success',
            'message' => 'Evaluation archived successfully!',
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
            ->event('topic_unarchived')
            ->withProperties([
                'status' => [
                    'old' => 'archived',
                    'new' => 'active'
                ],
            ])
            ->log("Evaluation with overall score with {$eval->overall_score} has been unarchive.");

        return response()->json([
            'status' => 'success',
            'message' => 'Evaluation unarchived successfully!',
            'eval' => $eval
        ]);
    }
}
