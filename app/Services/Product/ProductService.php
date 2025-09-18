<?php

namespace App\Services\Product;

use App\Models\Product\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $products = $this->productRepository->all($request);

        if ($products->isEmpty()) {
            throw new \Exception('Products not found', 204);
        }

        return $products;
    }

    public function register(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            return $this->productRepository->register($data);
        });
    }

    public function update(array $data, int $id): Product
    {
        return DB::transaction(function () use ($data, $id) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                throw new \Exception('Product not found', 400);
            }

            $this->productRepository->update($product, $data);

            return $this->productRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                throw new \Exception('Product not found', 400);
            }

            $productRemoved = $this->productRepository->delete($product);

            if (!$productRemoved) {
                throw new \Exception('An error occurred while removing the Product');
            }

            return $productRemoved;
        });
    }

    public function find(int $id): Product
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw new \Exception('Product not found', 400);
        }

        return $product;
    }
}
