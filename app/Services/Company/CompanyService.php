<?php

namespace App\Services\Company;

use App\Models\Company\Company;
use App\Repositories\Company\CompanyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $companies = $this->companyRepository->all($request);

        if ($companies->isEmpty()) {
            throw new \Exception('Companies not found', 204);
        }

        return $companies;
    }

    public function register(array $data): Company
    {
        return DB::transaction(function () use ($data) {
            return $this->companyRepository->register($data);
        });
    }

    public function update(array $data, int $id): Company
    {
        return DB::transaction(function () use ($data, $id) {
            $company = $this->companyRepository->find($id);

            if (!$company) {
                throw new \Exception('Company not found', 400);
            }

            $this->companyRepository->update($company, $data);

            return $this->companyRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $company = $this->companyRepository->find($id);

            if (!$company) {
                throw new \Exception('Company not found', 400);
            }

            $companyRemoved = $this->companyRepository->delete($company);

            if (!$companyRemoved) {
                throw new \Exception('An error occurred while removing the Company');
            }

            return $companyRemoved;
        });
    }

    public function find(int $id): Company
    {
        $company = $this->companyRepository->find($id);

        if (!$company) {
            throw new \Exception('Company not found', 400);
        }

        return $company;
    }
}
