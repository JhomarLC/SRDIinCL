<?php

use App\Http\Controllers\Admin\c;
use App\Http\Controllers\Admin\TrainingEvaluationController;
use App\Http\Controllers\Admin\TrainingEventController;
use Illuminate\Support\Facades\Route;

Route::prefix('training-evaluation-management')->group(function () {
    Route::get('/', [TrainingEventController::class, 'index'])->name('training-event-management.index');
    Route::get('/get-index', [TrainingEventController::class, 'getIndex'])->name('training-event-management.get-index');

    Route::post('/store', [TrainingEventController::class, 'store'])->name('training-event-management.store');
    Route::put('/{id}', [TrainingEventController::class, 'update'])->name('training-event-management.update');

    Route::post('/validate-step', [TrainingEvaluationController::class, 'validateStep'])->name('training-evaluation-management.validateStep');
    Route::post('/validate-all', [TrainingEvaluationController::class, 'validateAllSteps'])->name('training-evaluation-management.validateAll');

    // Nested topics under a specific speaker
    Route::prefix('{event}/evaluations')->group(function () {
        Route::get('/', [TrainingEvaluationController::class, 'index'])->name('training-evaluation-management.index');
        Route::get('/get-index', [TrainingEvaluationController::class, 'getIndex'])->name('training-evaluation-management.get-index');

        Route::get('/create', [TrainingEvaluationController::class, 'create'])->name('training-evaluation-management.create');
        Route::post('/store', [TrainingEvaluationController::class, 'store'])->name('training-evaluation-management.store');
        // Route::get('/{id}', [SpeakerEvaluationController::class, 'edit'])->name('speaker-eval.edit');
        // Route::put('/{id}', [SpeakerEvaluationController::class, 'update'])->name('speaker-eval.update');

        // Route::put('/{id}/archive', [SpeakerEvaluationController::class, 'archive'])->name('speaker-eval.archive');
        // Route::put('/{id}/unarchive', [SpeakerEvaluationController::class, 'unarchive'])->name('speaker-eval.unarchive');
    });
});



// Route::resource('speaker-management', SpeakerController::class);

