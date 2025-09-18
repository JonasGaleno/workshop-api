<?php

namespace App\Services\Company;

use App\Models\Company\DigitalCertification;
use App\Repositories\Company\DigitalCertificationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DigitalCertificationService
{
    public function __construct(
        protected DigitalCertificationRepositoryInterface $digitalCertificationRepository
    ) {
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $digitalCertifications = $this->digitalCertificationRepository->all($request);

        if ($digitalCertifications->isEmpty()) {
            throw new \Exception('Digital Certifications not found', 204);
        }

        return $digitalCertifications;
    }

    public function register(array $data): DigitalCertification
    {
        return DB::transaction(function () use ($data) {
            return $this->digitalCertificationRepository->register($data);
        });
    }

    public function update(array $data, int $id): DigitalCertification
    {
        return DB::transaction(function () use ($data, $id) {
            $digitalCertification = $this->digitalCertificationRepository->find($id);

            if (!$digitalCertification) {
                throw new \Exception('Digital Certification not found', 400);
            }

            $this->digitalCertificationRepository->update($digitalCertification, $data);

            return $this->digitalCertificationRepository->find($id);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $digitalCertification = $this->digitalCertificationRepository->find($id);

            if (!$digitalCertification) {
                throw new \Exception('Digital Certification not found', 400);
            }

            $digitalCertificationRemoved = $this->digitalCertificationRepository->delete($digitalCertification);

            if (!$digitalCertificationRemoved) {
                throw new \Exception('An error occurred while removing the Digital Certification');
            }

            return $digitalCertificationRemoved;
        });
    }

    public function find(int $id): DigitalCertification
    {
        $digitalCertification = $this->digitalCertificationRepository->find($id);

        if (!$digitalCertification) {
            throw new \Exception('Digital Certification not found', 400);
        }

        return $digitalCertification;
    }
}
