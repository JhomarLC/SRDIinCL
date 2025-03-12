<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmploymentType;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AEWSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::all();
        $employment_types = EmploymentType::all();

        return view('admin.aews-management.index', compact('positions', 'employment_types'));
    }

    public function getIndex()
    {
        $currentUser = auth()->user();
        $users = User::where('role', 'aews')->with(['profile' => function ($query) {
            $query->with('position', 'employment_type');
        }])->latest()->get();

        return DataTables::of($users)
            ->editColumn('full_name', function ($user) {
                $middleName = $user->middle_name ? ' ' . $user->middle_name : ''; // Add middle name if available
                $extName = $user->suffix ? ' ' . $user->suffix : ''; // Add middle name if available
                return "{$user->first_name} {$middleName} {$user->last_name} {$extName}";
            })
            ->addColumn('contact_number', function ($user) {
                return optional($user->profile)->contact_number ?? 'N/A'; // Safely access profile attribute
            })
            ->addColumn('position', function ($user) {
                return optional(optional($user->profile)->position)->position_name ?? 'N/A';
            })
            ->addColumn('employment_type', function ($user) {
                return optional(optional($user->profile)->employment_type)->employment_name ?? 'N/A';
            })
            ->addColumn('actions', function ($user) use ($currentUser) {

                if ($currentUser->id === $user->id) {
                    return '<span class="text-muted">You</span>';
                }

                $editButton = '<button class="btn btn-sm btn-success editAEW"
                                    data-id="' . $user->id . '"
                                    data-first_name="' . $user->first_name . '"
                                    data-middle_name="' . $user->middle_name . '"
                                    data-last_name="' . $user->last_name . '"
                                    data-suffix="' . $user->suffix . '"
                                    data-email="' . $user->email . '"
                                    data-region="' . optional($user->profile)->region . '"
                                    data-province="' . optional($user->profile)->province . '"
                                    data-municipality="' . optional($user->profile)->municipality . '"
                                    data-barangay="' . optional($user->profile)->barangay . '"
                                    data-contact_number="' . optional($user->profile)->contact_number . '"
                                    data-start_date="' . optional($user->profile)->start_date . '"
                                    data-position="' . optional(optional($user->profile)->position)->id . '"
                                    data-employment_type="' . optional(optional($user->profile)->employment_type)->id . '">
                                    <i class="ri-edit-fill"></i>
                                    Update
                                </button>';

                $activateButton = ($user->status === 'deactivated')
                    ? '<button class="btn btn-sm btn-secondary status-activate"
                            data-id="' . $user->id . '">
                            <i class="ri-service-fill"></i>
                            Activate
                        </button>'
                    : '';

                $deactivateButton = ($user->status === 'active')
                ? '<button class="btn btn-sm btn-danger status-deactivate"
                        data-id="' . $user->id . '">
                        <i class="ri-archive-fill"></i>
                        Deactivate
                    </button>'
                : '';

                return ($user->status === 'active' && $editButton ? $editButton : "") . ' ' . $activateButton . ' ' . $deactivateButton;
            })
            ->editColumn('status', function ($user) {
                return $user->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Deactivated</span>';
            })
            ->editColumn('job_status', function ($user) {
                $status = optional($user->profile)->job_status; // Safely access job_status
                switch ($status) {
                    case 'new':
                        return '<span class="badge bg-success">New</span>';
                    case 'old':
                        return '<span class="badge bg-warning">Old</span>';
                    case 'resigned':
                        return '<span class="badge bg-secondary">Resigned</span>';
                    case 'retired':
                        return '<span class="badge bg-primary">Retired</span>';
                    case 'transferred':
                        return '<span class="badge bg-info">Transferred</span>';
                    default:
                        return '<span class="badge bg-danger">Unknown</span>'; // Fallback for unexpected values
                }
            })

            ->rawColumns(['job_status', 'status', 'actions'])
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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',

            'region' => 'required|string',
            'province' => 'required|string',
            'municipality' => 'required|string',
            'barangay' => 'required|string',

            'position_id' => 'required|exists:positions,id',
            'employment_type_id' => 'required|exists:employment_types,id',
            'contact_number' => 'required|string|max:20',
            'start_date' => 'required|date',
            // 'end_date' => 'nullable|date',
        ]);

        $aews = User::create([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'aews',
        ]);

        $aews->profile()->create([
            'region' => $validatedData['region'],
            'province' => $validatedData['province'],
            'municipality' => $validatedData['municipality'],
            'barangay' => $validatedData['barangay'],
            'position_id' => $validatedData['position_id'],
            'employment_type_id' => $validatedData['employment_type_id'],
            'contact_number' => $validatedData['contact_number'],
            'start_date' => $validatedData['start_date'],
            // 'end_date' => $validatedData['end_date'],
        ]);

        // Log a single activity for both user and profile creation
        activity()
            ->causedBy(auth()->user())
            ->performedOn($aews)
            ->event('account_created')
            ->withProperties([
                'user' => $aews->only([
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix',
                    'email',
                    'role',
                    'status'
                ]),
                'profile' => optional($aews->profile)->only([
                    'region',
                    'province',
                    'municipality',
                    'barangay',
                    'position_id',
                    'employment_type_id',
                    'contact_number',
                    'start_date',
                    'end_date',
                ])
            ])
        ->log("New AEW account created for {$aews->first_name} {$aews->last_name} with profile details.");

        $aews->profile->updateStatus();

        return response()->json(['status' => 'success', 'message' => 'AEW created successfully!', 'aews' => $aews]);
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
    public function update(Request $request, $aews_management)
    {
        // Validate request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:255|unique:users,email,' . $aews_management,
            'password' => 'nullable|string|min:8|confirmed', // Password can be empty
            'position_id' => 'required|exists:positions,id',
            'employment_type_id' => 'required|exists:employment_types,id',
            'contact_number' => 'required|string|max:20',
            'start_date' => 'required|date',
        ]);

        // Find the User by ID
        $aews = User::findOrFail($aews_management);

        // Store original values before update
        $originalUserData = $aews->only([
            'first_name',
            'middle_name',
            'last_name',
            'suffix',
            'email',
        ]);

        $originalProfileData = $aews->profile->only([
            'position_id',
            'employment_type_id',
            'contact_number',
            'start_date',
        ]);

        // Update user details
        $aews->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
            'email' => $validatedData['email'],
        ]);

        // Update profile details
        $aews->profile->update([
            'position_id' => $validatedData['position_id'],
            'employment_type_id' => $validatedData['employment_type_id'],
            'contact_number' => $validatedData['contact_number'],
            'start_date' => $validatedData['start_date'],
        ]);

        // If profile exists, update status
        if ($aews->profile) {
            $aews->profile->updateStatus();
        }

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $aews->update([
                'password' => Hash::make($validatedData['password']),
            ]);
        }

        // Reload user data to get updated values
        $aews->load('profile');

        // Store only changed fields (old and new values)
        $changes = [];

        // Compare old and new user values
        foreach ($originalUserData as $key => $value) {
            if ($value !== $aews->$key) {
                $changes['user'][$key] = [
                    'old' => $value,
                    'new' => $aews->$key
                ];
            }
        }

        // Compare old and new profile values
        foreach ($originalProfileData as $key => $value) {
            if ($value !== $aews->profile->$key) {
                $changes['profile'][$key] = [
                    'old' => $value,
                    'new' => $aews->profile->$key
                ];
            }
        }

        // Log only if there are changes
        if (!empty($changes)) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($aews)
                ->event('account_updated')
                ->withProperties($changes)
                ->log("AEW account for {$aews->first_name} {$aews->last_name} was updated.");
        }

        return response()->json(['status' => 'success', 'message' => 'AEW updated successfully!', 'aews' => $aews]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Deactivate the specified user.
     */
    public function deactivate(string $id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->id == $id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot deactivate your own account.'
            ]);
        }

        if ($user->status === 'deactivated') {
            return response()->json([
                'status' => 'error',
                'message' => 'This AEW account is already deactivated.'
            ]);
        }

        $user->update(['status' => 'deactivated']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->event('deactivated')
            ->withProperties([
                'status' => [
                    'old' => 'active',
                    'new' => 'deactivated'
                ],
        ])
        ->log("{$user->first_name} {$user->last_name}'s account has been deactivated.");

        return response()->json([
            'status' => 'success',
            'message' => 'AEW account deactivated successfully!'
        ]);
    }

    /**
     * Activate the specified user.
     */
    public function activate(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->status === 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'This AEW account is already active.'
            ]);
        }
        $user->update(['status' => 'active']);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->event('activated')
            ->withProperties([
                'status' => [
                    'old' => 'deactivated',
                    'new' => 'active'
                ],
        ])
        ->log("{$user->first_name} {$user->last_name}'s account has been activated.");

        return response()->json([
            'status' => 'success',
            'message' => 'AEW account activated successfully!'
        ]);
    }
}
