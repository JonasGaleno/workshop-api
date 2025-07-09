<?php

namespace App\Repositories;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function register(array $data): User;
}
