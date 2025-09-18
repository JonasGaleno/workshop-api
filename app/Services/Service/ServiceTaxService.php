<?php

namespace App\Services\Service;

use App\Models\Service\ServiceTax;
use App\Repositories\Service\ServiceTaxRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceTaxService
{
    public function __construct(
        protected ServiceTaxRepositoryInterface $serviceTaxRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $servicesTaxes = $this->serviceTaxRepository->all($request);

        if ($servicesTaxes->isEmpty()) {
            throw new ModelNotFoundException('No Services Taxes found');
        }

        return $servicesTaxes;
    }

    public function register(array $data): ServiceTax
    {
        return DB::transaction(function () use ($data) {
            return $this->serviceTaxRepository->register($data);
        });
    }

    public function update(array $data, int $id): ServiceTax
    {
        return DB::transaction(function () use ($data, $id) {
            $serviceTax = $this->serviceTaxRepository->find($id);

            if (!$serviceTax) {
                throw new ModelNotFoundException('Service Tax not found');
            }

            return $this->serviceTaxRepository->update($serviceTax, $data);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $serviceTax = $this->serviceTaxRepository->find($id);

            if (!$serviceTax) {
                throw new ModelNotFoundException('Service Tax not found');
            }

            $serviceTaxRemoved = $this->serviceTaxRepository->delete($serviceTax);

            if (!$serviceTaxRemoved) {
                throw new \Exception('An error occurred while removing the Service Tax');
            }

            return $serviceTaxRemoved;
        });
    }

    public function find(int $id): ServiceTax
    {
        $serviceTax = $this->serviceTaxRepository->find($id);

        if (!$serviceTax) {
            throw new ModelNotFoundException('Service Tax not found');
        }

        return $serviceTax;
    }
}
