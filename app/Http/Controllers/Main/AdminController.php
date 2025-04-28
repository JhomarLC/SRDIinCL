<?php

namespace App\Http\Controllers\Main;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin-management.index');
    }

    public function getIndex()
    {
        $currentUser = auth()->user();
        $users = User::all()->where('role', 'admin');

        return DataTables::of($users)
            ->editColumn('full_name', function ($user) {
                $middleName = $user->middle_name ? ' ' . $user->middle_name : ''; // Add middle name if available
                $suffix = $user->suffix ? $user->suffix : '';
                return "{$user->first_name} {$middleName} {$user->last_name} {$suffix}";
            })
            ->addColumn('actions', function ($user) use ($currentUser) {

                if ($currentUser->id === $user->id) {
                    return '<span class="text-muted">You</span>';
                }

                $editButton = '<button class="btn btn-sm btn-success editAdmin"
                                    data-id="' . $user->id . '"
                                    data-first_name="' . $user->first_name . '"
                                    data-middle_name="' . $user->middle_name . '"
                                    data-last_name="' . $user->last_name . '"
                                    data-suffix="' . $user->suffix . '"
                                    data-email="' . $user->email . '">
                                    <i class="ri-edit-fill"></i> Update
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
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-management.create');
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
        ]);

        $admin = User::create([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'admin',
            'status' => 'active', // Default status
        ]);

        // Log a single activity for admin
        activity()
            ->causedBy(auth()->user())
            ->performedOn($admin)
            ->event('account_created')
            ->withProperties([
                'admin' => $admin->only([
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix',
                    'email',
                    'role',
                    'status'
                ]),
            ])
        ->log("New admin account created for {$admin->first_name} {$admin->last_name}");

        return response()->json(['status' => 'success', 'message' => 'Admin created successfully!', 'admin' => $admin]);
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
    public function edit(User $admin_management)
    {
        $admin = $admin_management;
        return view('admin-management.update', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $admin_management)
    {
        // Validate request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin_management,
            'password' => 'nullable|string|min:8|confirmed', // Password can be empty
        ]);

        // Find the admin by ID
        $admin = User::findOrFail($admin_management);

        // Store original values before update
        $originalUserData = $admin->only([
            'first_name',
            'middle_name',
            'last_name',
            'suffix',
            'email',
        ]);

        // Update only provided fields
        $admin->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
            'email' => $validatedData['email'], // Required, so no need for ??
        ]);

        // Reload user data to get updated values
        $admin->load('profile');

        // Store only changed fields (old and new values)
        $changes = [];

        // Compare old and new user values
        foreach ($originalUserData as $key => $value) {
            if ($value !== $admin->$key) {
                $changes['user'][$key] = [
                    'old' => $value,
                    'new' => $admin->$key
                ];
            }
        }
          // Only update password if a new one is provided
        if ($request->filled('password')) {
            $admin->update([
                'password' => Hash::make($validatedData['password']),
            ]);

            $changes['user']['password'] = [
                'old' => '********',
                'new' => '********'
            ];
        }

         // Log only if there are changes
         if (!empty($changes)) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($admin)
                ->event('account_updated')
                ->withProperties($changes)
                ->log("Admin account for {$admin->first_name} {$admin->last_name} was updated.");
        }

        return response()->json(['status' => 'success', 'message' => 'Admin updated successfully!', 'admin' => $admin]);
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
                'message' => 'This admin account is already deactivated.'
            ]);
        }

        $user->update(['status' => 'deactivated']);

          // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn(model: $user)
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
            'message' => 'Admin account deactivated successfully!'
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
                'message' => 'This admin account is already active.'
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
            'message' => 'Admin account activated successfully!'
        ]);
    }

    /**
     * Export users as an Excel file.
     */
    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}
