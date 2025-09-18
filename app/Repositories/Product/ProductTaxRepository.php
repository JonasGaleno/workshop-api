<?php

namespace App\Repositories\Product;

use App\Models\Product\ProductTax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductTaxRepository implements ProductTaxRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'products_taxes_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['products_taxes'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = ProductTax::query();

            // Filtros de busca exata
            $exactFilters = ['tax_id', 'product_id', 'uf'];

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

    public function register(array $data): ?ProductTax
    {
        return ProductTax::create($data)->load([
            'product:id',
            'tax:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(ProductTax $productTax, array $data): ProductTax
    {
        $productTax->update($data);

        return $productTax->refresh()->load([
            'product:id',
            'tax:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function delete(ProductTax $productTax): bool
    {
        return $productTax->delete();
    }

    public function find(int $id): ?ProductTax
    {
        $cacheKey = "product_tax_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), fn () => 
            ProductTax::with([
                'product:id',
                'tax:id',
                'createdBy:id',
                'updatedBy:id',
            ])->find($id)
        );
    }
}
