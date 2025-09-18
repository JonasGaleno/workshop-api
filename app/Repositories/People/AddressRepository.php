<?php

namespace App\Repositories\People;

use App\Models\People\Address;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AddressRepository implements AddressRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'addresses_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['addresses'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Address::query();

            // Filtros de busca parcial
            $likeFilters = ['description', 'country', 'state', 'uf'];

            foreach ($request->only($likeFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            // Filtros de busca exata
            $exactFilters = ['person_id', 'main_address'];

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

    public function register(array $data): ?Address
    {
        return Address::create($data)->load([
            'people:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Address $address, array $data): int
    {
        return $address->update($data);
    }

    public function delete(Address $address): bool
    {
        return $address->delete();
    }

    public function find(int $id): ?Address
    {
        $cacheKey = "address_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Address::find($id);
        });
    }
}
