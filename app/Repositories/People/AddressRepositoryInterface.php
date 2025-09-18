<?php

namespace App\Repositories\People;

use App\Models\People\Address;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface AddressRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Address;

    public function update(Address $address, array $data): int;

    public function delete(Address $address): bool;

    public function find(int $id): ?Address;
}
