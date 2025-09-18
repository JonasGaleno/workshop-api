<?php

namespace App\Services\Company;

use App\Models\Company\Employee;
use App\Repositories\Company\EmployeeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function __construct(
        protected EmployeeRepositoryInterface $employeeRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $employees = $this->employeeRepository->all($request);

        if ($employees->isEmpty()) {
            throw new \Exception('Employees not found', 204);
        }

        return $employees;
    }

    public function register(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            return $this->employeeRepository->register($data);
        });
    }

    public function update(array $data, int $id): Employee
    {
        return DB::transaction(function () use ($data, $id) {
            $employee = $this->employeeRepository->find($id);

            if (!$employee) {
                throw new \Exception('Employee not found', 400);
            }

            $this->employeeRepository->update($employee, $data);

            return $this->employeeRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $employee = $this->employeeRepository->find($id);

            if (!$employee) {
                throw new \Exception('Employee not found', 400);
            }

            $employeeRemoved = $this->employeeRepository->delete($employee);

            if (!$employeeRemoved) {
                throw new \Exception('An error occurred while removing the Employee');
            }

            return $employeeRemoved;
        });
    }

    public function find(int $id): Employee
    {
        $employee = $this->employeeRepository->find($id);

        if (!$employee) {
            throw new \Exception('Employee not found', 400);
        }

        return $employee;
    }
}
