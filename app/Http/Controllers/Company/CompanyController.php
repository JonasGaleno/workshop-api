<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyRegisterRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Services\Company\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $companyService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $companies = $this->companyService->all($request);

            return response()->json($companies, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Companies',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $company = $this->companyService->find($id);

            return response()->json($company, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Company',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(CompanyRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $company = $this->companyService->register($validatedData);

            return response()->json($company, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(CompanyUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $company = $this->companyService->update($validatedData, $id);

            return response()->json($company, 200);
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
            $this->companyService->delete($id);

            return response()->json(['message' => 'Company deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
