<?php

use App\Http\Controllers\Admin\AEWSController;
use Illuminate\Support\Facades\Route;

Route::get('/aews-management/get-index', [AEWSController::class, 'getIndex'])
        ->name('aews-management.get-index');

Route::put('/aews-management/{id}/deactivate', [AEWSController::class, 'deactivate'])
        ->name('aews-management.deactivate');

Route::put('/aews-management/{id}/activate', [AEWSController::class, 'activate'])
        ->name('aews-management.activate');

Route::resource('aews-management', AEWSController::class);