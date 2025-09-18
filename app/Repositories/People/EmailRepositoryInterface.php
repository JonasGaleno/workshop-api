<?php

namespace App\Repositories\People;

use App\Models\People\Email;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface EmailRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Email;

    public function update(Email $email, array $data): int;

    public function delete(Email $email): bool;

    public function find(int $id): ?Email;
}
