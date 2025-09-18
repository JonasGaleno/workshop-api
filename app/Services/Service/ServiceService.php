<?php

namespace App\Services\Service;

use App\Models\Service\Service;
use App\Repositories\Service\ServiceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    public function __construct(
        protected ServiceRepositoryInterface $serviceRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $services = $this->serviceRepository->all($request);

        if ($services->isEmpty()) {
            throw new ModelNotFoundException('No Services found');
        }

        return $services;
    }

    public function register(array $data): Service
    {
        return DB::transaction(function () use ($data) {
            return $this->serviceRepository->register($data);
        });
    }

    public function update(array $data, int $id): Service
    {
        return DB::transaction(function () use ($data, $id) {
            $service = $this->serviceRepository->find($id);

            if (!$service) {
                throw new ModelNotFoundException('Service not found');
            }

            return $this->serviceRepository->update($service, $data);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $service = $this->serviceRepository->find($id);

            if (!$service) {
                throw new ModelNotFoundException('Service not found');
            }

            $serviceRemoved = $this->serviceRepository->delete($service);

            if (!$serviceRemoved) {
                throw new \Exception('An error occurred while removing the Service');
            }

            return $serviceRemoved;
        });
    }

    public function find(int $id): Service
    {
        $service = $this->serviceRepository->find($id);

        if (!$service) {
            throw new ModelNotFoundException('Service not found');
        }

        return $service;
    }
}
