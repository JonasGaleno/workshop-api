<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Company\{
    CompanyRepository,
    CompanyRepositoryInterface,
    DigitalCertificationRepository,
    DigitalCertificationRepositoryInterface,
    EmployeeRepository,
    EmployeeRepositoryInterface,
};

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /* Company */
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        /* Employee */
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        /* Digital Certification */
        $this->app->bind(DigitalCertificationRepositoryInterface::class, DigitalCertificationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
