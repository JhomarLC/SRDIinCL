<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmploymentType;
use App\Models\Position;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $positions = Position::all();
        $employment_types = EmploymentType::all();
        return view('auth.register', compact(['positions', 'employment_types']));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
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
            'status' => 'pending'
        ]);


        $profile = $aews->profile()->create([
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

        $aews->profile->updateStatus();

        event(new Registered($aews));

        Auth::login($aews);

        return redirect(RouteServiceProvider::redirectTo());
    }
}
