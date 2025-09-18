<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\VehicleRegisterRequest;
use App\Http\Requests\People\VehicleUpdateRequest;
use App\Services\People\VehicleService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(
        protected VehicleService $vehicleService
    ) {
    }

    public function index(Request $request)
    {
        try {
            $vehicles = $this->vehicleService->all($request);

            return response()->json($vehicles, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for Vehicles',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $vehicle = $this->vehicleService->find($id);

            return response()->json($vehicle, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while searching for the Vehicle',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(VehicleRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $vehicle = $this->vehicleService->register($validatedData);

            return response()->json($vehicle, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(VehicleUpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();

            $vehicle = $this->vehicleService->update($validatedData, $id);

            return response()->json($vehicle, 200);
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
            $this->vehicleService->delete($id);

            return response()->json(['message' => 'Vehicle deleted'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
