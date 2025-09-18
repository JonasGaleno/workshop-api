<?php

namespace App\Repositories\System;

use App\Models\System\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'permissions_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Permission::query();

            // Ordenação
            $sortBy = $request->input('sort_by', 'created_at');
            $sortDirection = $request->input('sort_direction', 'desc');

            $query->orderBy($sortBy, $sortDirection);

            // Paginação
            $perPage = $request->input('per_page', 10);

            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?Permission
    {
        return Permission::create($data)->load([
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Permission $permission, array $data): int
    {
        return $permission->update($data);
    }

    public function delete(Permission $permission): bool
    {
        return $permission->delete();
    }

    public function find(int $id): ?Permission
    {
        $cacheKey = "permission_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Permission::find($id);
        });
    }
}
