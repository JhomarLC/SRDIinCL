<?php

use App\Http\Controllers\Main\TrainingEvaluationController;
use App\Http\Controllers\Main\TrainingEventController;
use Illuminate\Support\Facades\Route;

Route::prefix('training-evaluation-management')->group(function () {
    Route::get('/', [TrainingEventController::class, 'index'])->name('training-event-management.index');
    Route::get('/get-index', [TrainingEventController::class, 'getIndex'])->name('training-event-management.get-index');

    Route::post('/store', [TrainingEventController::class, 'store'])->name('training-event-management.store');
    Route::put('/{id}', [TrainingEventController::class, 'update'])->name('training-event-management.update');

    Route::put('/{id}/archive', [TrainingEventController::class, 'archive'])->name('training-event-management.archive');
    Route::put('/{id}/unarchive', [TrainingEventController::class, 'unarchive'])->name('training-event-management.unarchive');

    Route::post('/validate-step', [TrainingEvaluationController::class, 'validateStep'])->name('training-evaluation-management.validateStep');
    Route::post('/validate-all', [TrainingEvaluationController::class, 'validateAllSteps'])->name('training-evaluation-management.validateAll');

    Route::get('/export/full', [TrainingEvaluationController::class, 'exportFullTrainingEvaluations'])
        ->name('training-evaluation-management.export.full');

    Route::get('/{eventId}/export', [TrainingEvaluationController::class, 'exportTrainingEventEvaluations'])
        ->name('training-evaluation-management.export.single');

    // Nested topics under a specific speaker
    Route::prefix('{event}/evaluations')->group(function () {
        Route::get('/', [TrainingEvaluationController::class, 'index'])->name('training-evaluation-management.index');
        Route::get('/get-index', [TrainingEvaluationController::class, 'getIndex'])->name('training-evaluation-management.get-index');

        Route::get('/create', [TrainingEvaluationController::class, 'create'])->name('training-evaluation-management.create');
        Route::post('/store', [TrainingEvaluationController::class, 'store'])->name('training-evaluation-management.store');
        Route::get('/{id}', [TrainingEvaluationController::class, 'edit'])->name('training-evaluation-management.edit');
        Route::put('/{id}', [TrainingEvaluationController::class, 'update'])->name('training-evaluation-management.update');

        Route::put('/{id}/archive', [TrainingEvaluationController::class, 'archive'])->name('training-evaluation-management.archive');
        Route::put('/{id}/unarchive', [TrainingEvaluationController::class, 'unarchive'])->name('training-evaluation-management.unarchive');
    });
});



// Route::resource('speaker-management', SpeakerController::class);

