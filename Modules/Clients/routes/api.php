<?php

use Illuminate\Support\Facades\Route;
use Modules\Clients\app\Http\Controllers\AuthController;


Route::prefix('clients')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:clients.register');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:clients.login');
});

Route::middleware(['auth:sanctum'])->prefix('clients')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
});
