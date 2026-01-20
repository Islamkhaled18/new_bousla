<?php

use Illuminate\Support\Facades\Route;
use Modules\Clients\app\Http\Controllers\ClientsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clients', ClientsController::class)->names('clients');
});
