<?php

namespace App\Repositories\Company;

use App\Models\Company\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface EmployeeRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?Employee;

    public function update(Employee $employee, array $data): int;

    public function delete(Employee $employee): bool;

    public function find(int $id): ?Employee;
}
