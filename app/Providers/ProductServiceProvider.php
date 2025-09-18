<?php

namespace App\Providers;

use App\Repositories\Product\{
    ProductRepository,
    ProductRepositoryInterface,
    ProductTaxRepository,
    ProductTaxRepositoryInterface
};
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /* Product */
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        /* Product Tax */
        $this->app->bind(ProductTaxRepositoryInterface::class, ProductTaxRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
