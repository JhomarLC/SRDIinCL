<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use App\Models\SpeakerTopic;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SpeakerTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $speaker = Speaker::findOrFail($id);

        return view('admin.speaker-management.speaker-topics.index', compact('speaker'));
    }

    public function getIndex(string $id)
    {
        // Get only topics for the specific speaker, eager load speaker relationship
        $speaker_topics = SpeakerTopic::with('speaker')
                        ->where('speaker_id', $id)->get();
        return DataTables::of($speaker_topics)
            ->addColumn('actions', function ($topic)  {
                $viewButton  = ($topic->status !== 'archived')
                    ?  '<button class="btn btn-sm btn-secondary"
                            data-id="' . $topic->id . '">
                            <i class="ri-eye-fill"></i>
                            View Evaluations
                        </button>'
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

                return $viewButton . ' ' . ($topic->status === 'active' && $editButton ? $editButton : "") . ' ' . $activateButton . ' ' . $deactivateButton;
            })
            ->editColumn('topic_date', function ($topic) {
                return $topic->formatted_topic_date;
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
            'topic_date' => 'nullable|string|max:255',
        ]);

        $topic = SpeakerTopic::create([
            'speaker_id' => $id,
            'topic_discussed' => $validatedData['topic_discussed'],
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
                    'topic_date'
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
