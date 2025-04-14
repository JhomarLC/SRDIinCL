<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use App\Models\SpeakerEvaluation;
use App\Models\SpeakerTopic;
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
                'nickname' => 'nullable|string|max:100',
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
            $speaker_topic->speaker_evaluation->avg(function ($evaluation) {
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
            ->addColumn('actions', function ($topic)  {
                $viewButton  = ($topic->status !== 'archived')
                            ? '<a href=""
                                    class="btn btn-sm btn-secondary">
                                    <i class="ri-eye-fill"></i> View Evaluation
                                </a>'
                            : '';
                $editButton = '<button class="btn btn-sm btn-success editTopic"
                                    data-id="' . $topic->id . '"
                                    data-topic_discussed="' . $topic->topic_discussed . '"
                                    data-topic_date="' . $topic->topic_date . '">
                                    <i class="ri-edit-fill"></i> Update
                                </button>';

                $activateButton = ($topic->status === 'archived')
                    ? '<button class="btn btn-sm btn-secondary status-activate"
                            data-id="' . $topic->id . '">
                            <i class="ri-service-fill"></i>
                            Unarchive
                        </button>'
                    : '';

                $deactivateButton = ($topic->status === 'active')
                ? '<button class="btn btn-sm btn-danger status-archive"
                        data-id="' . $topic->id . '">
                        <i class="ri-archive-fill"></i>
                        Archive
                    </button>'
                : '';

                return  $viewButton . ' ' . ($topic->status === 'active' && $editButton ? $editButton : "") . ' ' . $activateButton . ' ' . $deactivateButton;
            })
            ->addColumn('overall_score', function ($topic)  {
                return $topic->overall_score . " (" . scoreLabel($topic->overall_score) . ")";
            })
            ->editColumn('status', function ($topic) {
                return $topic->status === 'active'
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
