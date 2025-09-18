<?php

namespace App\Providers;

use App\Repositories\Service\{
    ServiceRepository,
    ServiceRepositoryInterface,
    ServiceTaxRepository,
    ServiceTaxRepositoryInterface
};
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /* Service */
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        /* Service Tax */
        $this->app->bind(ServiceTaxRepositoryInterface::class, ServiceTaxRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
