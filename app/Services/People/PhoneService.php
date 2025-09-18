<?php

namespace App\Services\People;

use App\Models\People\Phone;
use App\Repositories\People\PhoneRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhoneService
{
    public function __construct(
        protected PhoneRepositoryInterface $phoneRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $phone = $this->phoneRepository->all($request);

        if ($phone->isEmpty()) {
            throw new \Exception('Phone not found', 204);
        }

        return $phone;
    }

    public function register(array $data): Phone
    {
        return DB::transaction(function () use ($data) {
            return $this->phoneRepository->register($data);
        });
    }

    public function update(array $data, int $id): Phone
    {
        return DB::transaction(function () use ($data, $id) {
            $phone = $this->phoneRepository->find($id);

            if (!$phone) {
                throw new \Exception('Phone not found', 400);
            }

            $this->phoneRepository->update($phone, $data);

            return $this->phoneRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $phone = $this->phoneRepository->find($id);

            if (!$phone) {
                throw new \Exception('Phone not found', 400);
            }

            $phoneRemoved = $this->phoneRepository->delete($phone);

            if (!$phoneRemoved) {
                throw new \Exception('An error occurred while removing the Phone');
            }

            return $phoneRemoved;
        });
    }

    public function find(int $id): Phone
    {
        $phone = $this->phoneRepository->find($id);

        if (!$phone) {
            throw new \Exception('Phone not found', 400);
        }

        return $phone;
    }
}
