<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.aews-management.index');
    }

    public function getIndex()
    {
        $currentUser = auth()->user();
        $users = User::where('role', 'aews')->latest()->get();

        return DataTables::of($users)
            ->editColumn('full_name', function ($user) {
                $middleName = $user->middle_name ? ' ' . $user->middle_name : ''; // Add middle name if available
                $extName = $user->suffix ? ' ' . $user->suffix : ''; // Add middle name if available
                return "{$user->first_name} {$middleName} {$user->last_name} {$extName}";
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
                                    <i class="ri-edit-line"></i> Update
                                </button>';

                $activateButton = ($user->status === 'disabled')
                    ? '<button class="btn btn-sm btn-secondary status-activate"
                            data-id="' . $user->id . '"
                            <i class="ri-service-fill"></i>
                            Activate
                        </button>'
                    : '';

                $deactivateButton = ($user->status === 'active')
                ? '<button class="btn btn-sm btn-danger status-deactivate"
                        data-id="' . $user->id . '"
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
        ]);

        // Find the admin by ID
        $admin = User::findOrFail($aews_management);

        // Update only provided fields
        $admin->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
            'email' => $validatedData['email'], // Required, so no need for ??
        ]);

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $admin->update([
                'password' => Hash::make($validatedData['password']),
            ]);
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