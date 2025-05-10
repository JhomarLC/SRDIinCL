<?php

use App\Http\Controllers\Main\BaselineMonitoringController;
use Illuminate\Support\Facades\Route;

Route::get('/baseline-monitoring/get-index', [BaselineMonitoringController::class, 'getIndex'])
        ->name('baseline-monitoring.get-index');

// Route::get('/farmers-profile/export', [FarmersProfileController::class, 'exportFarmersProfile'])
//         ->name('farmers-profile.export');

// Route::get('/farmers-profile/get-trainings', [FarmersProfileController::class, 'getTrainings'])
// ->name('farmers-profile.get-trainings');

// Route::post('/validate-step', [FarmersProfileController::class, 'validateStep'])->name('participant.validateStep');
// Route::post('/validate-all', [FarmersProfileController::class, 'validateAllSteps'])->name('participant.validateAll');

Route::resource('baseline-monitoring', BaselineMonitoringController::class);

