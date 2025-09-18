<?php

namespace App\Repositories\People;

use App\Models\People\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VehicleRepository implements VehicleRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'vehicles_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['vehicles'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Vehicle::query();

            // Filtros de busca parcial
            $likeFilters = ['name', 'brand', 'tag', 'color', 'model', 'engine'];

            foreach ($request->only($likeFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            // Filtros de busca exata
            $exactFilters = ['person_id', 'year'];

            foreach ($request->only($exactFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, $value);
                }
            }

            // Ordenação
            $sortBy = $request->input('sort_by', 'created_at');
            $sortDirection = $request->input('sort_direction', 'desc');

            if (!in_array($sortBy, ['id', 'description', 'created_at'])) {
                $sortBy = 'created_at';
            }
            if (!in_array(strtolower($sortDirection), ['asc', 'desc', 'ASC', 'DESC'])) {
                $sortDirection = 'desc';
            }

            // Paginação
            $perPage = $request->input('per_page', 10);

            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?Vehicle
    {
        return Vehicle::create($data)->load([
            'people:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Vehicle $vehicle, array $data): int
    {
        return $vehicle->update($data);
    }

    public function delete(Vehicle $vehicle): bool
    {
        return $vehicle->delete();
    }

    public function find(int $id): ?Vehicle
    {
        $cacheKey = "vehicle_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Vehicle::find($id);
        });
    }
}
