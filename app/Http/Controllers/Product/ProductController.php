<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRegisterRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $products = $this->productService->all($request);

            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Products',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $product = $this->productService->find($id);

            return response()->json($product, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Product',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(ProductRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $product = $this->productService->register($validatedData);

            return response()->json($product, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(ProductUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $product = $this->productService->update($validatedData, $id);

            return response()->json($product, 200);
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
            $this->productService->delete($id);

            return response()->json(['message' => 'Product deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
