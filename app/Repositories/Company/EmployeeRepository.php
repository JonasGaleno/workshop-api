<?php

namespace App\Repositories\Company;

use App\Models\Company\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'employees_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['employees'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Employee::query();

            // Filtros
            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', $request->name);
            }

            if ($request->has('expertise') && !empty($request->expertise)) {
                $query->where('expertise', $request->expertise);
            }

            if ($request->has('service_comission_perc') && !empty($request->service_comission_perc)) {
                $query->where('service_comission_perc', $request->service_comission_perc);
            }

            if ($request->has('company_id') && !empty($request->company_id)) {
                $query->where('company_id', $request->company_id);
            }

            // Ordenação
            $sortBy = $request->input('sort_by', 'created_at');
            $sortDirection = $request->input('sort_direction', 'desc');

            $query->orderBy($sortBy, $sortDirection);

            // Paginação
            $perPage = $request->input('per_page', 10);

            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?Employee
    {
        return Employee::create($data)->load([
            'company:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Employee $employee, array $data): int
    {
        return $employee->update($data);
    }

    public function delete(Employee $employee): bool
    {
        return $employee->delete();
    }

    public function find(int $id): ?Employee
    {
        $cacheKey = "employee_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Employee::find($id);
        });
    }
}
