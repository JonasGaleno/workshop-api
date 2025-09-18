<?php

namespace App\Repositories\System;

use App\Models\System\User;

interface AuthRepositoryInterface
{
    public function register(array $data): User;
}
