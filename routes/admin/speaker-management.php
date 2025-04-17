<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AEWSController;
use App\Http\Controllers\Admin\SpeakerController;
use App\Http\Controllers\Admin\SpeakerEvaluationController;
use App\Http\Controllers\Admin\SpeakerTopicController;
use Illuminate\Support\Facades\Route;

Route::prefix('speaker-management')->group(function () {
    Route::get('/', [SpeakerController::class, 'index'])->name('speaker-management.index');
    Route::get('/get-index', [SpeakerController::class, 'getIndex'])->name('speaker-management.get-index');

    Route::post('/store', [SpeakerController::class, 'store'])->name('speaker-management.store');
    Route::put('/{id}', [SpeakerController::class, 'update'])->name('speaker-management.update');

    Route::put('/{id}/archive', [SpeakerController::class, 'archive'])->name('speaker-management.archive');
    Route::put('/{id}/unarchive', [SpeakerController::class, 'unarchive'])->name('speaker-management.unarchive');

    Route::post('/validate-step', [SpeakerEvaluationController::class, 'validateStep'])->name('speaker-eval.validateStep');

    // Nested topics under a specific speaker
    Route::prefix('{speaker}/topics')->group(function () {
        Route::get('/', [SpeakerTopicController::class, 'index'])->name('speaker-topics.index');
        Route::get('/get-index', [SpeakerTopicController::class, 'getIndex'])->name('speaker-topics.get-index');

        Route::post('/store', [SpeakerTopicController::class, 'store'])->name('speaker-topics.store');
        Route::put('/{id}', [SpeakerTopicController::class, 'update'])->name('speaker-topics.update');

        Route::put('/{id}/archive', [SpeakerTopicController::class, 'archive'])->name('speaker-topics.archive');
        Route::put('/{id}/unarchive', [SpeakerTopicController::class, 'unarchive'])->name('speaker-topics.unarchive');

        // Nested evaluations under a specific topic
        Route::prefix('{topic}/evaluations')->group(function () {
            Route::get('/', [SpeakerEvaluationController::class, 'index'])->name('speaker-eval.index');
            Route::get('/get-index', [SpeakerEvaluationController::class, 'getIndex'])->name('speaker-eval.get-index');

            Route::get('/create', [SpeakerEvaluationController::class, 'create'])->name('speaker-eval.create');
            Route::post('/store', [SpeakerEvaluationController::class, 'store'])->name('speaker-eval.store');

        });
    });
});



// Route::resource('speaker-management', SpeakerController::class);

