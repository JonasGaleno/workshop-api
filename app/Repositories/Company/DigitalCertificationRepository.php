<?php

namespace App\Repositories\Company;

use App\Models\Company\DigitalCertification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DigitalCertificationRepository implements DigitalCertificationRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'digital_certifications_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['digital_certifications'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = DigitalCertification::query();

            // Filtros
            if ($request->has('description') && !empty($request->description)) {
                $query->where('description', $request->description);
            }

            if ($request->has('cnpj') && !empty($request->cnpj)) {
                $query->where('cnpj', $request->cnpj);
            }

            if ($request->has('valid_until') && !empty($request->valid_until)) {
                $query->where('valid_until', $request->valid_until);
            }

            if ($request->has('is_active') && !empty($request->is_active)) {
                $query->where('is_active', $request->is_active);
            }

            if ($request->has('company_id') && !empty($request->company_id)) {
                $query->where('company_id', $request->company_id);
            }

            // Ordenação
            $sortBy = $request->input('sort_by', 'created_at');
            $sortDirection = $request->input('sort_direction', 'desc');

            $query->orderBy($sortBy, $sortDirection);

            // Paginação
            $perPage = $request->input('per_page', 10);

            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?DigitalCertification
    {
        return DigitalCertification::create($data)->load([
            'company:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(DigitalCertification $digitalCertification, array $data): int
    {
        return $digitalCertification->update($data);
    }

    public function delete(DigitalCertification $digitalCertification): bool
    {
        return $digitalCertification->delete();
    }

    public function find(int $id): ?DigitalCertification
    {
        $cacheKey = "digital_certification_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return DigitalCertification::find($id);
        });
    }
}
