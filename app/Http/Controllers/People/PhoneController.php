<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\PhoneRegisterRequest;
use App\Http\Requests\People\PhoneUpdateRequest;
use App\Services\People\PhoneService;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function __construct(
        protected PhoneService $phoneService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $phones = $this->phoneService->all($request);

            return response()->json($phones, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Phones',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $phone = $this->phoneService->find($id);

            return response()->json($phone, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Phone',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(PhoneRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $phone = $this->phoneService->register($validatedData);

            return response()->json($phone, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(PhoneUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $phone = $this->phoneService->update($validatedData, $id);

            return response()->json($phone, 200);
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
            $this->phoneService->delete($id);

            return response()->json(['message' => 'Phone deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
