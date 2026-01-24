<?php

use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\PrivacyPolicyController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->prefix('general')->group(function () {
    
    Route::get('about-us', [AboutUsController::class, 'index']);
    Route::get('ads',[AdController::class,'index']);
    Route::get('faqs',[FaqController::class,'index']);
    Route::get('privacy-policies',[PrivacyPolicyController::class,'index']);
});
