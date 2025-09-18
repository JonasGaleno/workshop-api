<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'products_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['products'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Product::query();

            // Filtros de busca parcial
            $likeFilters = ['description'];

            foreach ($request->only($likeFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            // Filtros de busca exata
            $exactFilters = ['price_sale', 'price_cost', 'is_active', 'company_id'];

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
        });
    }

    public function register(array $data): ?Product
    {
        return Product::create($data)->load([
            'company:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Product $product, array $data): int
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function find(int $id): ?Product
    {
        $cacheKey = "product_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Product::find($id);
        });
    }
}
