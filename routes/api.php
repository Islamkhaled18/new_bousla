<?php

use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\AdController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->prefix('general')->group(function () {
    
    Route::get('about-us', [AboutUsController::class, 'index']);
    Route::get('ads',[AdController::class,'index']);
});
