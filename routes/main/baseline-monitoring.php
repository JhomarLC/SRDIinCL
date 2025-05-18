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

// 1) Register a resource but exclude the default `create` (and you can exclude any others)
//    This will give you index, store, show, edit, update, destroy—but no create.
Route::resource('baseline-monitoring', BaselineMonitoringController::class)
     ->except(['create', 'store']);

// 2) Define your custom `create` route *after* (or before) the resource.
//    Here we’re accepting 2 parameters, but you can adjust as needed.
Route::get('baseline-monitoring/create/{id}/{season}',
    [BaselineMonitoringController::class, 'create'])
    ->name('baseline-monitoring.create');

Route::post('baseline-monitoring/create/{id}/{season}',
    [BaselineMonitoringController::class, 'store'])
    ->name('baseline-monitoring.store');
