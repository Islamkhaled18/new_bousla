<?php

use Illuminate\Support\Facades\Route;
use Modules\Doctors\app\Http\Controllers\DoctorsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('doctors', DoctorsController::class)->names('doctors');
});
