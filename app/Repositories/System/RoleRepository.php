<?php

namespace App\Repositories\System;

use App\Models\System\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RoleRepository implements RoleRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'roles_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Role::query();

            // Ordenação
            $sortBy = $request->input('sort_by', 'created_at');
            $sortDirection = $request->input('sort_direction', 'desc');

            $query->orderBy($sortBy, $sortDirection);

            // Paginação
            $perPage = $request->input('per_page', 10);

            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?Role
    {
        return Role::create($data)->load([
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Role $role, array $data): int
    {
        return $role->update($data);
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function find(int $id): ?Role
    {
        $cacheKey = "role_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Role::find($id);
        });
    }
}
