<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AEWSController;
use App\Http\Controllers\Admin\SpeakerController;
use Illuminate\Support\Facades\Route;


Route::get('/speaker-management/get-index', [SpeakerController::class, 'getIndex'])
        ->name('speaker-management.get-index');

Route::put('/speaker-management/{id}/archive', [SpeakerController::class, 'archive'])
->name('speaker-management.archive');

Route::put('/speaker-management/{id}/unarchive', [SpeakerController::class, 'unarchive'])
->name('speaker-management.unarchive');

Route::resource('speaker-management', SpeakerController::class);
