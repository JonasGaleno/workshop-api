<?php

namespace App\Repositories\People;

use App\Models\People\People;
use App\Repositories\People\PeopleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PeopleRepository implements PeopleRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'people_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['people'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = People::query();

            // Filtros de busca parcial
            $likeFilters = ['name', 'business_name', 'fantasy_name'];

            foreach ($request->only($likeFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            // Filtros de busca exata
            $exactFilters = ['person_type', 'cpf_cnpj', 'company_id'];

            foreach ($request->only($exactFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, $value);
                }
            }


            // Ordenação
            $sortBy = $request->input('sort_by', 'created_at');
            $sortDirection = $request->input('sort_direction', 'desc');

            if (!in_array($sortBy, ['id', 'name', 'business_name', 'fantasy_name', 'created_at'])) {
                $sortBy = 'created_at';
            }
            if (!in_array(strtolower($sortDirection), ['asc', 'desc', 'ASC', 'DESC'])) {
                $sortDirection = 'desc';
            }

            $query->orderBy($sortBy, $sortDirection);

            // Paginação
            $perPage = $request->input('per_page', 10);

            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?People
    {
        return People::create($data)->load([
            'company:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(People $people, array $data): int
    {
        return $people->update($data);
    }

    public function delete(People $people): bool
    {
        return $people->delete();
    }

    public function find(int $id): ?People
    {
        $cacheKey = "person_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return People::find($id);
        });
    }
}
