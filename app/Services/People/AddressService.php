<?php

namespace App\Services\People;

use App\Models\People\Address;
use App\Repositories\People\AddressRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressService
{
    public function __construct(
        protected AddressRepositoryInterface $addressRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $addresses = $this->addressRepository->all($request);

        if ($addresses->isEmpty()) {
            throw new \Exception('Addresses not found', 204);
        }

        return $addresses;
    }

    public function register(array $data): Address
    {
        return DB::transaction(function () use ($data) {
            return $this->addressRepository->register($data);
        });
    }

    public function update(array $data, int $id): Address
    {
        return DB::transaction(function () use ($data, $id) {
            $address = $this->addressRepository->find($id);

            if (!$address) {
                throw new \Exception('Address not found', 400);
            }

            $this->addressRepository->update($address, $data);

            return $this->addressRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $address = $this->addressRepository->find($id);

            if (!$address) {
                throw new \Exception('Address not found', 400);
            }

            $addressRemoved = $this->addressRepository->delete($address);

            if (!$addressRemoved) {
                throw new \Exception('An error occurred while removing the Address');
            }

            return $addressRemoved;
        });
    }

    public function find(int $id): Address
    {
        $address = $this->addressRepository->find($id);

        if (!$address) {
            throw new \Exception('Address not found', 400);
        }

        return $address;
    }
}
