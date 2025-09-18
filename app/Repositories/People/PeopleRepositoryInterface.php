<?php

namespace App\Repositories\People;

use App\Models\People\People;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface PeopleRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?People;

    public function update(People $people, array $data): int;

    public function delete(People $people): bool;

    public function find(int $id): ?People;
}
