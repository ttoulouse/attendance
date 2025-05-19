<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    // Bind 'trashed_course' to include soft-deleted courses.
    Route::bind('trashed_course', function ($value) {
        return \App\Models\Course::withTrashed()->where('id', $value)->firstOrFail();
    });

    parent::boot();

    }
}
