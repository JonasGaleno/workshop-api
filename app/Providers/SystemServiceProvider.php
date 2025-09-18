<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\System\{
    AuthRepository,
    AuthRepositoryInterface,
    PermissionRepository,
    PermissionRepositoryInterface,
    RoleRepository,
    RoleRepositoryInterface,
    UserRepository,
    UserRepositoryInterface,
};

class SystemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /* Auth */
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        /* User */
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        /* Role */
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        /* Permission */
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
