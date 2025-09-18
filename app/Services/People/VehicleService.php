<?php

namespace App\Services\People;

use App\Models\People\Vehicle;
use App\Repositories\People\VehicleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleService
{
    public function __construct(
        protected VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $vehicles = $this->vehicleRepository->all($request);

        if ($vehicles->isEmpty()) {
            throw new \Exception('Vehicles not found', 204);
        }

        return $vehicles;
    }

    public function register(array $data): Vehicle
    {
        return DB::transaction(function () use ($data) {
            return $this->vehicleRepository->register($data);
        });
    }

    public function update(array $data, int $id): Vehicle
    {
        return DB::transaction(function () use ($data, $id) {
            $vehicle = $this->vehicleRepository->find($id);

            if (!$vehicle) {
                throw new \Exception('Vehicle not found', 400);
            }

            $this->vehicleRepository->update($vehicle, $data);

            return $this->vehicleRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $vehicle = $this->vehicleRepository->find($id);

            if (!$vehicle) {
                throw new \Exception('Vehicle not found', 400);
            }

            $vehicleRemoved = $this->vehicleRepository->delete($vehicle);

            if (!$vehicleRemoved) {
                throw new \Exception('An error occurred while removing the Vehicle');
            }

            return $vehicleRemoved;
        });
    }

    public function find(int $id): Vehicle
    {
        $vehicle = $this->vehicleRepository->find($id);

        if (!$vehicle) {
            throw new \Exception('Vehicle not found', 400);
        }

        return $vehicle;
    }
}
