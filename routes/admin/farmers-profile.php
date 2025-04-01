<?php

use App\Http\Controllers\Admin\FarmersProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/farmers-profile/get-index', [FarmersProfileController::class, 'getIndex'])
        ->name('farmers-profile.get-index');

Route::get('/farmers-profile/get-trainings', [FarmersProfileController::class, 'getTrainings'])
->name('farmers-profile.get-trainings');

Route::post('/validate-step', [FarmersProfileController::class, 'validateStep'])->name('participant.validateStep');
Route::resource('farmers-profile', FarmersProfileController::class);

