<?php

use App\Http\Controllers\Admin\FarmersProfileController;
use Illuminate\Support\Facades\Route;

Route::resource('farmers-profile', FarmersProfileController::class);
