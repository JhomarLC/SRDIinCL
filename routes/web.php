<?php

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
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('admin.dashboard');

    // ADMIN MANAGEMENT
    require __DIR__.'/admin/admin-management.php';
    // AEWS MANAGEMENT
    require __DIR__.'/admin/aews-management.php';

});

// AEWS
Route::middleware('auth', 'role:aews')->group(function (){
    Route::get('/dashboard', function () {
        return view('aews.index');
    })->name('dashboard');
});

require __DIR__.'/auth.php';