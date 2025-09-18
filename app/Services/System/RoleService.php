<?php

namespace App\Services\System;

use App\Models\System\Role;
use App\Repositories\System\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $roles = $this->roleRepository->all($request);

        if ($roles->isEmpty()) {
            throw new \Exception('Roles not found');
        }

        return $roles;
    }

    public function register(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            return $this->roleRepository->register($data);
        });
    }

    public function update(array $data, int $id): Role
    {
        return DB::transaction(function () use ($data, $id) {
            $role = $this->roleRepository->find($id);

            if (!$role) {
                throw new \Exception('Role not found');
            }

            $this->roleRepository->update($role, $data);

            return $this->roleRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $role = $this->roleRepository->find($id);

            if (!$role) {
                throw new \Exception('Role not found');
            }

            $roleRemoved = $this->roleRepository->delete($role);

            if (!$roleRemoved) {
                throw new \Exception('An error occurred while removing the Role');
            }

            return $roleRemoved;
        });
    }

    public function find(int $id): Role
    {
        $role = $this->roleRepository->find($id);

        if (!$role) {
            throw new \Exception('Role not found');
        }

        return $role;
    }
}
