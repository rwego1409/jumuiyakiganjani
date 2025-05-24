<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PalmPesaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/palmpesa.php', 'palmpesa'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/palmpesa.php' => config_path('palmpesa.php'),
        ], 'palmpesa-config');
    }
}