<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Product;

    public function update(Product $product, array $data): int;

    public function delete(Product $product): bool;

    public function find(int $id): ?Product;
}
