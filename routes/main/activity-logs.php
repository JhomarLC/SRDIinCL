<?php

use App\Http\Controllers\Main\ActivityLogsController;
use Illuminate\Support\Facades\Route;

Route::get('/activity-logs', [ActivityLogsController::class, 'index'])->name('activity-logs.index');
Route::get('/activity-logs/get-index', [ActivityLogsController::class, 'getIndex'])->name('activity-logs.get-index');
