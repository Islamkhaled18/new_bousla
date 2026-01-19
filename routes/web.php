<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\JoinRequestController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TermConditionController;
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
    Route::post('job-titles/{job_title}/toggle-status', [JobTitleController::class, 'toggleStatus'])->name('job-titles.toggle-status')->middleware(['throttle:60,1']);

    //governorates
    Route::resource('governorates', GovernorateController::class);
    Route::post('governorates/{governorate}/toggle-status', [GovernorateController::class, 'toggleStatus'])->name('governorates.toggle-status')->middleware(['throttle:60,1']);

    //cities
    Route::resource('cities', CityController::class);
    Route::post('cities/{city}/toggle-status', [CityController::class, 'toggleStatus'])->name('cities.toggle-status')->middleware(['throttle:60,1']);

    //areas
    Route::resource('areas', AreaController::class);
    Route::post('areas/{area}/toggle-status', [AreaController::class, 'toggleStatus'])->name('areas.toggle-status')->middleware(['throttle:60,1']);

    //main-categories
    Route::resource('main-categories', MainCategoryController::class);
    Route::post('main-categories/{main_category}/toggle-status', [MainCategoryController::class, 'toggleStatus'])->name('main-categories.toggle-status')->middleware(['throttle:60,1']);

    //categories
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status')->middleware(['throttle:60,1']);

    //ads
    Route::resource('ads', AdController::class);
    Route::post('ads/{ad}/toggle-status', [AdController::class, 'toggleStatus'])->name('ads.toggle-status')->middleware(['throttle:60,1']);

    //settings
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::post('update/{id}', [SettingController::class, 'update'])->name('settings.update');
    });

    //terms
    Route::resource('terms', TermConditionController::class);

    //about-us
    Route::resource('about-us', AboutUsController::class);

    //admins
    Route::resource('admins', AdminController::class);
    Route::post('admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admins.toggle-status')->middleware(['throttle:60,1']);

    //roles
    Route::resource('roles', RoleController::class);

    //join-requests
    Route::resource('join-requests', JoinRequestController::class);
    Route::delete('/join-request-images/{id}', [JoinRequestController::class, 'destroyOrganizationImage'])->name('join-requests.images.destroy');
    Route::post('join-requests/{id}/toggle-status', [JoinRequestController::class, 'toggleStatus'])->name('join-requests.toggleStatus');
});

require __DIR__ . '/auth.php';
