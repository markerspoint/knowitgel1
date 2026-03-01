<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;

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
        // Prevent accidental Vite dev-server mode on production deploys.
        if ($this->app->environment('production')) {
            Vite::useHotFile(storage_path('framework/vite.hot'));
        }
    }
}
