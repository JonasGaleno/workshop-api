<?php

namespace App\Repositories\Service;

use App\Models\Service\ServiceTax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ServiceTaxRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?ServiceTax;

    public function update(ServiceTax $serviceTax, array $data): ServiceTax;

    public function delete(ServiceTax $serviceTax): bool;

    public function find(int $id): ?ServiceTax;
}
