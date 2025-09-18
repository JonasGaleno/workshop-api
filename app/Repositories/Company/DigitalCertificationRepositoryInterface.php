<?php

namespace App\Repositories\Company;

use App\Models\Company\DigitalCertification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface DigitalCertificationRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator;

    public function register(array $data): ?DigitalCertification;

    public function update(DigitalCertification $digitalCertification, array $data): int;

    public function delete(DigitalCertification $digitalCertification): bool;

    public function find(int $id): ?DigitalCertification;
}
