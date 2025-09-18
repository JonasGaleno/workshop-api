<?php

namespace App\Services\System;

use App\Models\System\User;
use App\Repositories\System\AuthRepositoryInterface;

class AuthService
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    ) {
    }

    public function register(array $data): User
    {
        return $this->authRepository->register($data);
    }
}
