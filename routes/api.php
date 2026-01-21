<?php

use App\Http\Controllers\Api\AboutUsController;
use Illuminate\Support\Facades\Route;

Route::get('about-us-mobile', [AboutUsController::class, 'index']);