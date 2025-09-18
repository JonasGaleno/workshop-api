<?php

namespace App\Repositories\System;

use App\Models\System\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Role;

    public function update(Role $role, array $data): int;

    public function delete(Role $role): bool;

    public function find(int $id): ?Role;
}
