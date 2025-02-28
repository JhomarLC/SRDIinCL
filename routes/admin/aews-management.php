<?php

use App\Http\Controllers\Admin\AEWSController;
use Illuminate\Support\Facades\Route;

Route::resource('aews-management', AEWSController::class);