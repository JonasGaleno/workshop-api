<?php

namespace App\Services\People;

use App\Models\People\Email;
use App\Repositories\People\EmailRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailService
{
    public function __construct(
        protected EmailRepositoryInterface $emailRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $emails = $this->emailRepository->all($request);

        if ($emails->isEmpty()) {
            throw new \Exception('Emails not found', 204);
        }

        return $emails;
    }

    public function register(array $data): Email
    {
        return DB::transaction(function () use ($data) {
            return $this->emailRepository->register($data);
        });
    }

    public function update(array $data, int $id): Email
    {
        return DB::transaction(function () use ($data, $id) {
            $email = $this->emailRepository->find($id);

            if (!$email) {
                throw new \Exception('Email not found', 400);
            }

            $this->emailRepository->update($email, $data);

            return $this->emailRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $email = $this->emailRepository->find($id);

            if (!$email) {
                throw new \Exception('Email not found', 400);
            }

            $emailRemoved = $this->emailRepository->delete($email);

            if (!$emailRemoved) {
                throw new \Exception('An error occurred while removing the Email');
            }

            return $emailRemoved;
        });
    }

    public function find(int $id): Email
    {
        $email = $this->emailRepository->find($id);

        if (!$email) {
            throw new \Exception('Email not found', 400);
        }

        return $email;
    }
}
