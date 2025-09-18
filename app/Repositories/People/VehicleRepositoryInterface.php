<?php

namespace App\Repositories\People;

use App\Models\People\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface VehicleRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Vehicle;

    public function update(Vehicle $vehicle, array $data): int;

    public function delete(Vehicle $vehicle): bool;

    public function find(int $id): ?Vehicle;
}
