<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyRegisterRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Requests\Company\EmployeeRegisterRequest;
use App\Http\Requests\Company\EmployeeUpdateRequest;
use App\Services\Company\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $employeeService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $employees = $this->employeeService->all($request);

            return response()->json($employees, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Employees',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $employee = $this->employeeService->find($id);

            return response()->json($employee, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Employee',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(EmployeeRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $employee = $this->employeeService->register($validatedData);

            return response()->json($employee, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(EmployeeUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $employee = $this->employeeService->update($validatedData, $id);

            return response()->json($employee, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->employeeService->delete($id);

            return response()->json(['message' => 'Employee deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
