<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AksesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        require_once app_path() . '/Http/Helpers/Akses.php';
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
