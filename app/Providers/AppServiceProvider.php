<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Contribution;
use App\Observers\ContributionObserver;
use App\Services\ClickPesaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClickPesaService::class, function ($app) {
            $config = config('services.clickpesa');
            return new ClickPesaService(
                $config['vendor_id'],
                $config['client_id'],
                $config['api_key'],
                $config['base_url']
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Contribution::observe(ContributionObserver::class);
    }
}
