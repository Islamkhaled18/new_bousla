<?php

namespace App\Providers;

use App\Models\JobTitle;
use App\Observers\JobTitleObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JobTitle::observe(JobTitleObserver::class);
    }
}
