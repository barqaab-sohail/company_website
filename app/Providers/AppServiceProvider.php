<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        // Keep indexed strings compatible with older MySQL/MariaDB servers
        // whose utf8mb4 indexes are limited to 1000 bytes.
        Schema::defaultStringLength(191);
    }
}
