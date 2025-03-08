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
                                    data-contact_number="' . optional($user->profile)->contact_number . '"
                                    data-start_date="' . optional($user->profile)->start_date . '"
                                    data-position="' . optional(optional($user->profile)->position)->id . '"
                                    data-employment_type="' . optional(optional($user->profile)->employment_type)->id . '">
                                    <i class="ri-edit-fill"></i>
                                    Update
                                </button>';

                $activateButton = ($user->status === 'disabled')
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
            'position_id' => $validatedData['position_id'],
            'employment_type_id' => $validatedData['employment_type_id'],
            'contact_number' => $validatedData['contact_number'],
            'start_date' => $validatedData['start_date'],
            // 'end_date' => $validatedData['end_date'],
        ]);

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

        // Find the admin by ID
        $aews = User::findOrFail($aews_management);

        // Update only provided fields
        $aews->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
            'email' => $validatedData['email'], // Required, so no need for ??
        ]);

        $aews->profile()->update([
            'position_id' => $validatedData['position_id'],
            'employment_type_id' => $validatedData['employment_type_id'],
            'contact_number' => $validatedData['contact_number'],
            'start_date' => $validatedData['start_date'],
            // 'end_date' => $validatedData['end_date'],
        ]);

        $aews->profile->updateStatus();

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $aews->update([
                'password' => Hash::make($validatedData['password']),
            ]);
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

        if ($user->status === 'disabled') {
            return response()->json([
                'status' => 'error',
                'message' => 'This AEW account is already disabled.'
            ]);
        }

        $user->update(['status' => 'disabled']);

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

        return response()->json([
            'status' => 'success',
            'message' => 'AEW account activated successfully!'
        ]);
    }
}