<?php

namespace App\Repositories\System;

use App\Models\System\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface PermissionRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Permission;

    public function update(Permission $permission, array $data): int;

    public function delete(Permission $permission): bool;

    public function find(int $id): ?Permission;
}
