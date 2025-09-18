<?php

namespace App\Services\People;

use App\Models\People\People;
use App\Repositories\People\PeopleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeopleService
{
    public function __construct(
        protected PeopleRepositoryInterface $peopleRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $people = $this->peopleRepository->all($request);

        if ($people->isEmpty()) {
            throw new \Exception('People not found', 204);
        }

        return $people;
    }

    public function register(array $data): People
    {
        return DB::transaction(function () use ($data) {
            return $this->peopleRepository->register($data);
        });
    }

    public function update(array $data, int $id): People
    {
        return DB::transaction(function () use ($data, $id) {
            $person = $this->peopleRepository->find($id);

            if (!$person) {
                throw new \Exception('Person not found', 400);
            }

            $this->peopleRepository->update($person, $data);

            return $this->peopleRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $person = $this->peopleRepository->find($id);

            if (!$person) {
                throw new \Exception('Person not found', 400);
            }

            $personRemoved = $this->peopleRepository->delete($person);

            if (!$personRemoved) {
                throw new \Exception('An error occurred while removing the Person');
            }

            return $personRemoved;
        });
    }

    public function find(int $id): People
    {
        $person = $this->peopleRepository->find($id);

        if (!$person) {
            throw new \Exception('Person not found', 400);
        }

        return $person;
    }
}
