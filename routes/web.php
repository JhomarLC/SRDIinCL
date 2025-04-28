<?php

use App\Http\Controllers\Admin\ActivityLogsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AEWSController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');

    // FARMERS PROFILE
    require __DIR__.'/main/farmers-profile.php';
    // SPEAKER EVAL
    require __DIR__.'/main/speaker-management.php';
    // TRANING EVAL
    require __DIR__.'/main/training-evaluation-management.php';
    // ADMIN MANAGEMENT
    require __DIR__.'/main/admin-management.php';
    // AEWS MANAGEMENT
    require __DIR__.'/main/aews-management.php';
    // ACTIVITY LOGS/
    require __DIR__.'/main/activity-logs.php';
});

require __DIR__.'/auth.php';
