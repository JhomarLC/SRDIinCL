<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.speaker-management.index');
    }

    public function getIndex()
    {
        $speakers = Speaker::all();

        return DataTables::of($speakers)
            ->editColumn('full_name', function ($speaker) {
                $middleName = $speaker->middle_name ? ' ' . $speaker->middle_name : ''; // Add middle name if available
                $suffix = $speaker->suffix ? $speaker->suffix : '';
                return "{$speaker->first_name} {$middleName} {$speaker->last_name} {$suffix}";
            })
            ->addColumn('total_rating', function ($speaker) {
                    return '<span class="badge bg-info text-black">Add Speaker Evaluation</span>';
            })
            ->addColumn('actions', function ($speaker)  {
                $viewButton  = ($speaker->status !== 'archived')
                        ? '<a href="' . route('speaker-topics.index', $speaker->id) . '"
                                class="btn btn-sm btn-secondary">
                                <i class="ri-eye-fill"></i> View Topics
                            </a>'
                        : '';

                $editButton = '<button class="btn btn-sm btn-success editSpeaker"
                                    data-id="' . $speaker->id . '"
                                    data-first_name="' . $speaker->first_name . '"
                                    data-middle_name="' . $speaker->middle_name . '"
                                    data-last_name="' . $speaker->last_name . '"
                                    data-suffix="' . $speaker->suffix . '">
                                    <i class="ri-edit-fill"></i> Update
                                </button>';

                $activateButton = ($speaker->status === 'archived')
                    ? '<button class="btn btn-sm btn-secondary status-activate"
                            data-id="' . $speaker->id . '">
                            <i class="ri-service-fill"></i>
                            Unarchive
                        </button>'
                    : '';

                $deactivateButton = ($speaker->status === 'active')
                ? '<button class="btn btn-sm btn-danger status-archive"
                        data-id="' . $speaker->id . '">
                        <i class="ri-archive-fill"></i>
                        Archive
                    </button>'
                : '';

                return $viewButton . ' ' . ($speaker->status === 'active' && $editButton ? $editButton : "") . ' ' . $activateButton . ' ' . $deactivateButton;
            })
            ->editColumn('status', function ($speaker) {
                return $speaker->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Archived</span>';
            })
            ->rawColumns(['status', 'total_rating', 'actions'])
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
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
        ]);

        $speaker = Speaker::create([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
        ]);

        // Log a single activity for admin
        activity()
            ->causedBy(auth()->user())
            ->performedOn($speaker)
            ->event('speaker_created')
            ->withProperties([
                'admin' => $speaker->only([
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix',
                    'status'
                ]),
            ])
        ->log("New speaker account created for {$speaker->first_name} {$speaker->last_name}");

        return response()->json(['status' => 'success', 'message' => 'Speaker created successfully!', 'speaker' => $speaker]);
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
    public function update(Request $request, $speaker_management)
    {
         // Validate request
         $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
        ]);

        // Find the admin by ID
        $speaker = Speaker::findOrFail($speaker_management);

        // Store original values before update
        $originalUserData = $speaker->only([
            'first_name',
            'middle_name',
            'last_name',
            'suffix',
        ]);

        // Update only provided fields
        $speaker->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
        ]);


        // Store only changed fields (old and new values)
        $changes = [];

        // Compare old and new user values
        foreach ($originalUserData as $key => $value) {
            if ($value !== $speaker->$key) {
                $changes['user'][$key] = [
                    'old' => $value,
                    'new' => $speaker->$key
                ];
            }
        }

         // Log only if there are changes
         if (!empty($changes)) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($speaker)
                ->event('account_updated')
                ->withProperties($changes)
                ->log("Speaker account for {$speaker->first_name} {$speaker->last_name} was updated.");
        }

        return response()->json(['status' => 'success', 'message' => 'Speaker updated successfully!', 'speaker' => $speaker]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    /**
     * Archive the speaker.
     */
    public function archive(string $id)
    {
        $speaker = Speaker::findOrFail($id);

        if ($speaker->status === 'archived') {
            return response()->json([
                'status' => 'error',
                'message' => 'This speaker is already archived.'
            ]);
        }

        $speaker->update(['status' => 'archived']);

          // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($speaker)
            ->event('archived')
            ->withProperties([
                'status' => [
                    'old' => 'active',
                    'new' => 'archived'
                ],
        ])
        ->log("{$speaker->first_name} {$speaker->last_name}'s record has been archived.");

        return response()->json([
            'status' => 'success',
            'message' => 'Speaker archived successfully!'
        ]);
    }

    /**
     * Unarchive the specified user.
     */
    public function unarchive(string $id)
    {
        $speaker = Speaker::findOrFail($id);

        if ($speaker->status === 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'This admin account is already active.'
            ]);
        }
        $speaker->update(['status' => 'active']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($speaker)
            ->event('activated')
            ->withProperties([
                'status' => [
                    'old' => 'deactivated',
                    'new' => 'active'
                ],
        ])
        ->log("{$speaker->first_name} {$speaker->last_name}'s account has been unarchived.");

        return response()->json([
            'status' => 'success',
            'message' => 'Speaker unarchived successfully!'
        ]);
    }

}
