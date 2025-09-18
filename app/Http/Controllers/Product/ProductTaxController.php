<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductTaxRegisterRequest;
use App\Http\Requests\Product\ProductTaxUpdateRequest;
use App\Services\Product\ProductTaxService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductTaxController extends Controller
{
    public function __construct(
        protected ProductTaxService $productTaxService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $productsTaxes = $this->productTaxService->all($request);

            return response()->json($productsTaxes, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Products Taxes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $productTax = $this->productTaxService->find($id);

            return response()->json($productTax, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Product Tax',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(ProductTaxRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $productTax = $this->productTaxService->register($validatedData);

            return response()->json($productTax, 201);
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

    public function update(ProductTaxUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $productTax = $this->productTaxService->update($validatedData, $id);

            return response()->json($productTax, 200);
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
            $this->productTaxService->delete($id);

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
