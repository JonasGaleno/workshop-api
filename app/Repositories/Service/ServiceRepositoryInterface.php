<?php

namespace App\Repositories\Service;

use App\Models\Service\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ServiceRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Service;

    public function update(Service $service, array $data): Service;

    public function delete(Service $service): bool;

    public function find(int $id): ?Service;
}
