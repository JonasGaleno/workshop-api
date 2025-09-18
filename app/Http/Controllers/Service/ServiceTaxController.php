<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceTaxRegisterRequest;
use App\Http\Requests\Service\ServiceTaxUpdateRequest;
use App\Services\Service\ServiceTaxService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ServiceTaxController extends Controller
{
    public function __construct(
        protected ServiceTaxService $serviceTaxService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $servicesTaxes = $this->serviceTaxService->all($request);

            return response()->json($servicesTaxes, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Services Taxes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $serviceTax = $this->serviceTaxService->find($id);

            return response()->json($serviceTax, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Service Tax',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(ServiceTaxRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $serviceTax = $this->serviceTaxService->register($validatedData);

            return response()->json($serviceTax, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(ServiceTaxUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $serviceTax = $this->serviceTaxService->update($validatedData, $id);

            return response()->json($serviceTax, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
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
            $this->serviceTaxService->delete($id);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
