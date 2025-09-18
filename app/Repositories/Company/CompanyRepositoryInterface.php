<?php

namespace App\Repositories\Company;

use App\Models\Company\Company;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface CompanyRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Company;

    public function update(Company $company, array $data): int;

    public function delete(Company $company): bool;

    public function find(int $id): ?Company;
}
