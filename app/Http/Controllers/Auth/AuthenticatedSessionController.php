<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();
        // Log the activity
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event('logged_in') // Corrected event name
            ->withProperties([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'status' => 'success', // Log successful login
            ])
            ->log("{$user->first_name} {$user->last_name} logged in successfully.");

        return redirect()->intended(RouteServiceProvider::redirectTo());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user(); // Get the authenticated user before logging out

        if ($user) {
            // Log the logout activity
            activity()
                ->causedBy($user)
                ->performedOn($user)
                ->event('logged_out')
                ->withProperties([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'status' => 'success',
                ])
                ->log("{$user->first_name} {$user->last_name} logged out.");
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
