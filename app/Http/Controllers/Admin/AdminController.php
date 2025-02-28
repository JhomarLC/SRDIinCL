<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.admin-management.index');
    }

    public function getIndex()
    {
        $users = User::all()->where('role', 'admin');

        return DataTables::of($users)
            ->addColumn('actions', function ($user) {
                $editButton = '<a href="' . route('admin-management.edit', $user->id) . '" class="btn btn-sm btn-success">
                                <i class="ri-edit-fill"></i> Update
                            </a>';

                $activateButton = ($user->status === 'disabled')
                    ? '<button class="btn btn-sm btn-secondary activateUser" data-bs-toggle="modal" data-id="' . $user->id . '" href="#activeAccount' . $user->id . '">
                            <i class="ri-service-fill"></i> Activate
                    </button>'
                    : '';

                $deactivateButton = ($user->status === 'active')
                    ? '<button class="btn btn-sm btn-danger deactivateUser" data-bs-toggle="modal" data-id="' . $user->id . '" href="#deactivateAccount' . $user->id . '">
                            <i class="ri-archive-fill"></i> Disable
                    </button>'
                    : '';

                return $editButton . ' ' . $activateButton . ' ' . $deactivateButton;
            })
            ->editColumn('status', function ($user) {
                return $user->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Disabled</span>';
            })
            ->editColumn('suffix', function ($user) {
                return $user->suffix ? $user->suffix : 'N/A';
            })
            // ->editColumn('updated_at', function ($user) {
            //     return $user->updated_at->format('h:i A | m/d/y');
            // })
            // ->editColumn('created_at', function ($user) {
            //     return $user->created_at->format('h:i A | M d, Y');
            // })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin-management.create');
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
            'password' => bcrypt($validatedData['password']),
            'role' => 'admin',
            'status' => 'active', // Default status
        ]);

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
        return view('admin.admin-management.update', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'admin_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $authenticatedAdmin = Auth::user();

        if (!Hash::check($request->admin_password, $authenticatedAdmin->password)) {
            return redirect()->back()->with('error', 'Your password is incorrect.');
        }

        $targetAdmin = User::findOrFail($id);

        $targetAdmin->password = Hash::make($request->password);
        $targetAdmin->save();

        return redirect()->route('admin-management.index')->with('success', 'Admin password updated successfully.');
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

        if (Auth::user()->id == $user->id) {
            return redirect()->back()->with('error', 'You cannot deactivate your own account.');
        }

        if ($user->status === 'disabled') {
            return redirect()->back()->with('error', 'This admin account is already disabled.');
        }

        $user->update(['status' => 'disabled']);

        return redirect()->route('admin-management.index')->with('success', 'Admin account deactivated successfully.');
    }

    /**
     * Activate the specified user.
     */
    public function activate(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->status === 'active') {
            return redirect()->back()->with('error', 'This admin account is already active.');
        }

        $user->update(['status' => 'active']);

        return redirect()->route('admin-management.index')->with('success', 'Admin account activated successfully.');
    }

    /**
     * Export users as an Excel file.
     */
    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}
