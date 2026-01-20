<?php

use Illuminate\Support\Facades\Route;
use Modules\Clients\app\Http\Controllers\AuthController;


Route::prefix('clients')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->prefix('clients')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});
