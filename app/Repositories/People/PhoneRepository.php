<?php

namespace App\Repositories\People;

use App\Models\People\Phone;
use App\Repositories\People\PhoneRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PhoneRepository implements PhoneRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'phones_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['phones'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Phone::query();

            // Filtros de busca parcial
            $likeFilters = ['description', 'number'];

            foreach ($request->only($likeFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            // Filtros de busca exata
            $exactFilters = ['person_id', 'main_number'];

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

    public function register(array $data): ?Phone
    {
        return Phone::create($data)->load([
            'people:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Phone $phone, array $data): int
    {
        return $phone->update($data);
    }

    public function delete(Phone $phone): bool
    {
        return $phone->delete();
    }

    public function find(int $id): ?Phone
    {
        $cacheKey = "phone_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Phone::find($id);
        });
    }
}
