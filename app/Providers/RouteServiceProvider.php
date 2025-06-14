<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    // public const HOME = '/dashboard';

    public static function redirectTo()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if user is deactivated
            if ($user->status === 'deactivated') {
                Auth::logout();
                session()->flash('error', 'Your account has been deactivated. Please contact support.');
                return '/login';
            }
            if ($user->status === 'pending') {
                Auth::logout();
                session()->flash('pending', 'Your account is currently pending approval. Please wait for an administrator to approve your access.');
                return '/login';
            }
                // Redirect based on role
                return '/dashboard';
            }

        return '/login';
    }


    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
