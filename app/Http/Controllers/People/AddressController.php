<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\AddressRegisterRequest;
use App\Http\Requests\People\AddressUpdateRequest;
use App\Services\People\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(
        protected AddressService $addressService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $addresses = $this->addressService->all($request);

            return response()->json($addresses, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Address',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $address = $this->addressService->find($id);

            return response()->json($address, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Address',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(AddressRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $address = $this->addressService->register($validatedData);

            return response()->json($address, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(AddressUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $address = $this->addressService->update($validatedData, $id);

            return response()->json($address, 200);
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
            $this->addressService->delete($id);

            return response()->json(['message' => 'Address deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
