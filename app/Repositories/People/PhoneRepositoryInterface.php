<?php

namespace App\Repositories\People;

use App\Models\People\Phone;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface PhoneRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Phone;

    public function update(Phone $phone, array $data): int;

    public function delete(Phone $phone): bool;

    public function find(int $id): ?Phone;
}
