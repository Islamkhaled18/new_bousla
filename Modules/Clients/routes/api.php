<?php


use Illuminate\Support\Facades\Route;
use Modules\Clients\app\Http\Controllers\AuthController;
use Modules\Clients\app\Http\Controllers\TermsConditionController;
use Modules\Clients\app\Http\Controllers\JobTitleController;

Route::prefix('clients')->group(function () {
    Route::get('terms-and-conditions', [TermsConditionController::class, 'index']);
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:clients.register');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:clients.login');
});

Route::middleware(['auth:sanctum'])->prefix('clients')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('job-titles', [JobTitleController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
});
