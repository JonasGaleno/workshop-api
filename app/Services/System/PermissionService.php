<?php

namespace App\Services\System;

use App\Models\System\Permission;
use App\Repositories\System\PermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function __construct(
        protected PermissionRepositoryInterface $permissionRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $permissions = $this->permissionRepository->all($request);

        if ($permissions->isEmpty()) {
            throw new \Exception('Permissions not found');
        }

        return $permissions;
    }

    public function register(array $data): Permission
    {
        return DB::transaction(function () use ($data) {
            return $this->permissionRepository->register($data);
        });
    }

    public function update(array $data, int $id): Permission
    {
        return DB::transaction(function () use ($data, $id) {
            $permission = $this->permissionRepository->find($id);

            if (!$permission) {
                throw new \Exception('Permission not found');
            }

            $this->permissionRepository->update($permission, $data);

            return $this->permissionRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $permission = $this->permissionRepository->find($id);

            if (!$permission) {
                throw new \Exception('Permission not found');
            }

            $permissionRemoved = $this->permissionRepository->delete($permission);

            if (!$permissionRemoved) {
                throw new \Exception('An error occurred while removing the Permission');
            }

            return $permissionRemoved;
        });
    }

    public function find(int $id): Permission
    {
        $permission = $this->permissionRepository->find($id);

        if (!$permission) {
            throw new \Exception('Permission not found');
        }

        return $permission;
    }
}
