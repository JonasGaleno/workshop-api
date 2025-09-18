<?php

namespace App\Services\Product;

use App\Models\Product\ProductTax;
use App\Repositories\Product\ProductTaxRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductTaxService
{
    public function __construct(
        protected ProductTaxRepositoryInterface $productTaxRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $productsTaxes = $this->productTaxRepository->all($request);

        if ($productsTaxes->isEmpty()) {
            throw new ModelNotFoundException('No Product Taxes found');
        }

        return $productsTaxes;
    }

    public function register(array $data): ProductTax
    {
        return DB::transaction(function () use ($data) {
            return $this->productTaxRepository->register($data);
        });
    }

    public function update(array $data, int $id): ProductTax
    {
        return DB::transaction(function () use ($data, $id) {
            $productTax = $this->productTaxRepository->find($id);

            if (!$productTax) {
                throw new ModelNotFoundException('Product Tax not found');
            }

            return $this->productTaxRepository->update($productTax, $data);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $productTax = $this->productTaxRepository->find($id);

            if (!$productTax) {
                throw new ModelNotFoundException('Product Tax not found');
            }

            $productTaxRemoved = $this->productTaxRepository->delete($productTax);

            if (!$productTaxRemoved) {
                throw new \Exception('An error occurred while removing the Product Tax');
            }

            return $productTaxRemoved;
        });
    }

    public function find(int $id): ProductTax
    {
        $productTax = $this->productTaxRepository->find($id);

        if (!$productTax) {
            throw new ModelNotFoundException('Product Tax not found');
        }

        return $productTax;
    }
}
