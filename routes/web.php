<?php

use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //job_titles
    Route::resource('job-titles', JobTitleController::class);
    Route::post('job-titles/{job_title}/toggle-status', [JobTitleController::class, 'toggleStatus'])->name('job-titles.toggle-status');

    //governorates
    Route::resource('governorates', GovernorateController::class);
    Route::post('governorates/{governorate}/toggle-status', [GovernorateController::class, 'toggleStatus'])->name('governorates.toggle-status');
});

require __DIR__ . '/auth.php';
