<?php

namespace App\Repositories\Product;

use App\Models\Product\ProductTax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ProductTaxRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?ProductTax;

    public function update(ProductTax $productTax, array $data): ProductTax;

    public function delete(ProductTax $productTax): bool;

    public function find(int $id): ?ProductTax;
}
