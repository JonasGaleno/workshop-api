<?php

namespace App\Providers;


use App\Repositories\People\{
    AddressRepository,
    AddressRepositoryInterface,
    EmailRepository,
    EmailRepositoryInterface,
    PeopleRepository,
    PeopleRepositoryInterface,
    PhoneRepository,
    PhoneRepositoryInterface,
    VehicleRepository,
    VehicleRepositoryInterface
};
use Illuminate\Support\ServiceProvider;

class PeopleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /* People */
        $this->app->bind(PeopleRepositoryInterface::class, PeopleRepository::class);
        /* Phone */
        $this->app->bind(PhoneRepositoryInterface::class, PhoneRepository::class);
        /* Email */
        $this->app->bind(EmailRepositoryInterface::class, EmailRepository::class);
        /* Address */
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        /* Vehicle */
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
