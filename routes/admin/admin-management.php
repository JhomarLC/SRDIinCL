<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AEWSController;
use Illuminate\Support\Facades\Route;



Route::get('/admin-management/get-index', [AdminController::class, 'getIndex'])
        ->name('admin-management.get-index');

Route::put('/admin-management/{id}/deactivate', [AdminController::class, 'deactivate'])
        ->name('admin-management.deactivate');

Route::put('/admin-management/{id}/activate', [AdminController::class, 'activate'])
        ->name('admin-management.activate');

Route::get('/admin-management/export', [AdminController::class, 'exportUsers'])
        ->name('admin-management.export');

Route::resource('admin-management', AdminController::class);