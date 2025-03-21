<?php

use App\Http\Controllers\Admin\FarmersProfileController;
use Illuminate\Support\Facades\Route;

Route::post('/validate-step', [FarmersProfileController::class, 'validateStep'])->name('participant.validateStep');
Route::resource('farmers-profile', FarmersProfileController::class);

