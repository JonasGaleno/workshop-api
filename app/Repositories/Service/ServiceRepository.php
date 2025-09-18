<?php

namespace App\Repositories\Service;

use App\Models\Service\Service;
use App\Repositories\Service\ServiceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'services_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['services'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Service::query();

            // Filtros de busca parcial
            $likeFilters = ['description'];

            foreach ($request->only($likeFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            // Filtros de busca exata
            $exactFilters = ['price_sale', 'type', 'is_active', 'company_id'];

            foreach ($request->only($exactFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, $value);
                }
            }

            // Ordenação
            $sortDirection = $request->input('sort_direction', 'desc');
            
            if (!in_array(strtolower($sortDirection), ['asc', 'desc', 'ASC', 'DESC'])) {
                $sortDirection = 'desc';
            }

            $query->orderBy('created_at', $sortDirection);

            // Paginação
            $perPage = $request->input('per_page', 10);

            return $query->paginate($perPage);

            // return $query->paginate($perPage)->withQueryString();
        });
    }

    public function register(array $data): ?Service
    {
        return Service::create($data)->load([
            'service:id',
            'tax:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Service $service, array $data): Service
    {
        $service->update($data);

        return $service->refresh()->load([
            'service:id',
            'tax:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function delete(Service $service): bool
    {
        return $service->delete();
    }

    public function find(int $id): ?Service
    {
        $cacheKey = "service_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), fn () => 
            Service::with([
                'service:id',
                'tax:id',
                'createdBy:id',
                'updatedBy:id',
            ])->find($id)
        );
    }
}
