<?php

namespace App\Http\Controllers\Main;

use App\Exports\SpeakerTopicsExport;
use App\Http\Controllers\Controller;
use App\Models\Speaker;
use App\Models\SpeakerTopic;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class SpeakerTopicController extends Controller
{
    public function exportSpeakerTopics($speakerId)
    {
        $speaker = Speaker::findOrFail($speakerId);
        $filename = 'Topics_of_' . $speaker->full_name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new SpeakerTopicsExport($speakerId), $filename);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $speaker = Speaker::findOrFail($id);

        return view('speaker-management.speaker-topics.index', compact('speaker'));
    }

    public function getIndex(string $speakerId)
    {
        $user = auth()->user();

        $query = SpeakerTopic::with('speaker')
                    ->where('speaker_id', $speakerId);

        // if ($user->isAew()) {
        //     if ($user->isProvincialAew()) {
        //         // Provincial AEW → only topics within their province
        //         $query->where('province_code', $user->profile->province);
        //     } elseif ($user->isMunicipalAew()) {
        //         // Municipal AEW → only topics within their municipality
        //         $query->where('municipality_code', $user->profile->municipality);
        //     }
        // }

        $speaker_topics = $query->get();

        return DataTables::of($speaker_topics)
            ->addColumn('actions', function ($topic) use ($speakerId, $user)  {
                  // Determine if the user is allowed to edit this topic
                $canEdit = true; // default

                if ($user->isAew()) {
                    if ($user->isProvincialAew()) {
                        $canEdit = $topic->province_code === $user->profile->province;
                    } elseif ($user->isMunicipalAew()) {
                        $canEdit = $topic->municipality_code === $user->profile->municipality;
                    }
                }

                $viewButton  = ($topic->status !== 'archived')
                        ? '<a href="' . route('speaker-eval.index', [$speakerId, $topic->id]) . '"
                                class="btn btn-sm btn-secondary">
                                <i class="ri-eye-fill"></i> View Evaluations
                            </a>'
                        : '';

                $editButton = $canEdit ? '<button class="btn btn-sm btn-success editTopic"
                                    data-id="' . $topic->id . '"
                                    data-topic_discussed="' . $topic->topic_discussed . '"
                                    data-topic_date="' . $topic->topic_date . '"
                                    data-province="' . $topic->province_code . '"
                                    data-municipality="' .$topic->municipality_code . '"
                                    data-barangay="' . $topic->barangay_code . '">
                                    <i class="ri-edit-fill"></i> Update
                                </button>' : '';

                $activateButton = ($canEdit && $topic->status === 'archived')
                    ? '<button class="btn btn-sm btn-secondary status-activate"
                            data-id="' . $topic->id . '">
                            <i class="ri-service-fill"></i>
                            Unarchive
                        </button>'
                    : '';

                $deactivateButton = ($canEdit && $topic->status === 'active')
                ? '<button class="btn btn-sm btn-danger status-archive"
                        data-id="' . $topic->id . '">
                        <i class="ri-archive-fill"></i>
                        Archive
                    </button>'
                : '';

                return $viewButton . ' ' . ($topic->status === 'active' && $editButton ? $editButton : "") . ' ' . $activateButton . ' ' . $deactivateButton;
            })
            ->addColumn('topic_location', function ($topic) {
                return $topic->full_address;
            })
            ->editColumn('topic_date', function ($topic) {
                return $topic->formatted_topic_date;
            })
            ->editColumn('topic_discussed', function ($topic) {
                return SpeakerTopic::getTopicLabel($topic->topic_discussed);
            })
            ->addColumn('average_evaluation_score', function ($topic) {
                if (is_null($topic->average_evaluation_score)) {
                    return 'No Evaluations';
                }
                return $topic->average_evaluation_score . ' (' .scoreLabel($topic->average_evaluation_score) . ')';
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'topic_discussed' => 'required|string|max:255',
            'province_code' => 'required|string',
            'municipality_code' => 'required|string',
            'barangay_code' => 'required|string',
            'topic_date' => 'nullable|string|max:255',
        ]);

        $topic = SpeakerTopic::create([
            'speaker_id' => $id,
            'topic_discussed' => $validatedData['topic_discussed'],
            'province_code' => $validatedData['province_code'],
            'municipality_code' => $validatedData['municipality_code'],
            'barangay_code' => $validatedData['barangay_code'],
            'topic_date' => $validatedData['topic_date'] ?? null,
        ]);

        // Log a single activity for admin
        activity()
            ->causedBy(auth()->user())
            ->performedOn($topic)
            ->event('topic_created')
            ->withProperties([
                'admin' => $topic->only([
                    'topic_discussed',
                    'topic_date',
                    'province_code',
                    'municipality_code',
                    'barangay_code'
                ]),
            ])
        ->log("New topic {$topic->topic_discussed} - {$topic->topic_date} for speaker created");

        return response()->json(['status' => 'success', 'message' => 'Speaker topic created successfully!', 'topic' => $topic]);
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
    public function update(Request $request, string $speakerId, string $topicId)
    {
        $validatedData = $request->validate([
            'topic_discussed' => 'required|string|max:255',
            'topic_date' => 'nullable|string|max:255',
            'province_code' => 'required|string',
            'municipality_code' => 'required|string',
            'barangay_code' => 'required|string',
        ]);

        // You can optionally check if the topic really belongs to the speaker
        $topic = SpeakerTopic::where('id', $topicId)
                            ->where('speaker_id', $speakerId)
                            ->with('speaker')
                            ->firstOrFail();

        $originalData = $topic->only(['topic_discussed', 'topic_date']);

        $topic->update([
            'topic_discussed' => $validatedData['topic_discussed'],
            'topic_date' => $validatedData['topic_date'] ?? null,
            'province_code' => $validatedData['province_code'],
            'municipality_code' => $validatedData['municipality_code'],
            'barangay_code' => $validatedData['barangay_code'],
        ]);

        $changes = [];
        foreach ($originalData as $key => $value) {
            if ($value !== $topic->$key) {
                $changes['topic'][$key] = [
                    'old' => $value,
                    'new' => $topic->$key,
                ];
            }
        }

        if (!empty($changes)) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($topic)
                ->event('topic_updated')
                ->withProperties($changes)
                ->log("Topic updated for speaker {$topic->speaker->full_name}.");
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Speaker topic updated successfully!',
            'topic' => $topic
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function archive(string $speakerId, string $topicId)
    {
        $topic = SpeakerTopic::where('id', $topicId)
                             ->where('speaker_id', $speakerId)
                             ->with('speaker')
                             ->firstOrFail();

        if ($topic->status === 'archived') {
            return response()->json([
                'status' => 'error',
                'message' => 'This topic is already archived.'
            ]);
        }

        $topic->update(['status' => 'archived']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($topic)
            ->event('topic_archived')
            ->withProperties([
                'status' => [
                    'old' => 'active',
                    'new' => 'archived'
                ],
            ])
            ->log("Topic '{$topic->topic_discussed}' for speaker {$topic->speaker->full_name} has been archived.");

        return response()->json([
            'status' => 'success',
            'message' => 'Topic archived successfully!',
            'topic' => $topic
        ]);
    }

    public function unarchive(string $speakerId, string $topicId)
    {
        $topic = SpeakerTopic::where('id', $topicId)
                             ->where('speaker_id', $speakerId)
                             ->with('speaker')
                             ->firstOrFail();

        if ($topic->status === 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'This topic is already active.'
            ]);
        }

        $topic->update(['status' => 'active']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($topic)
            ->event('topic_unarchived')
            ->withProperties([
                'status' => [
                    'old' => 'archived',
                    'new' => 'active'
                ],
            ])
            ->log("Topic '{$topic->topic_discussed}' for speaker {$topic->speaker->full_name} has been unarchived.");

        return response()->json([
            'status' => 'success',
            'message' => 'Topic unarchived successfully!',
            'topic' => $topic
        ]);
    }

}
