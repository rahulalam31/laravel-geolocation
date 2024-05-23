<?php

namespace App\Providers;

use App\Interfaces\GeolocationServiceInterface;
use App\Services\AbstractGeolocationService;
use Illuminate\Support\ServiceProvider;

class GeoIPProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GeolocationServiceInterface::class, AbstractGeolocationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
