<?php

namespace App\Repositories\Service;

use App\Models\Service\ServiceTax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceTaxRepository implements ServiceTaxRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'services_taxes_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['services_taxes'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = ServiceTax::query();

            // Filtros de busca exata
            $exactFilters = ['tax_id', 'service_id', 'uf'];

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

    public function register(array $data): ?ServiceTax
    {
        return ServiceTax::create($data)->load([
            'service:id',
            'tax:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(ServiceTax $serviceTax, array $data): ServiceTax
    {
        $serviceTax->update($data);

        return $serviceTax->refresh()->load([
            'service:id',
            'tax:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function delete(ServiceTax $serviceTax): bool
    {
        return $serviceTax->delete();
    }

    public function find(int $id): ?ServiceTax
    {
        $cacheKey = "service_tax_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), fn () => 
            ServiceTax::with([
                'service:id',
                'tax:id',
                'createdBy:id',
                'updatedBy:id',
            ])->find($id)
        );
    }
}
