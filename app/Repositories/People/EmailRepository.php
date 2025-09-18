<?php

namespace App\Repositories\People;

use App\Models\People\Email;
use App\Repositories\People\EmailRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmailRepository implements EmailRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $filters = $request->query();
        $cacheKey = 'emails_' . md5(json_encode($filters));
        $cacheTime = 10;
        
        return Cache::tags(['emails'])->remember($cacheKey, now()->addMinutes($cacheTime), function () use ($request) {
            $query = Email::query();

            // Filtros de busca parcial
            $likeFilters = ['description', 'email'];

            foreach ($request->only($likeFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            // Filtros de busca exata
            $exactFilters = ['person_id', 'main_contact'];

            foreach ($request->only($exactFilters) as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, $value);
                }
            }

            // Ordenação
            $sortBy = $request->input('sort_by', 'created_at');
            $sortDirection = $request->input('sort_direction', 'desc');

            if (!in_array($sortBy, ['id', 'description', 'created_at'])) {
                $sortBy = 'created_at';
            }
            if (!in_array(strtolower($sortDirection), ['asc', 'desc', 'ASC', 'DESC'])) {
                $sortDirection = 'desc';
            }

            // Paginação
            $perPage = $request->input('per_page', 10);

            return $query->paginate($perPage);
        });
    }

    public function register(array $data): ?Email
    {
        return Email::create($data)->load([
            'people:id',
            'createdBy:id',
            'updatedBy:id',
        ]);
    }

    public function update(Email $email, array $data): int
    {
        return $email->update($data);
    }

    public function delete(Email $email): bool
    {
        return $email->delete();
    }

    public function find(int $id): ?Email
    {
        $cacheKey = "email_{$id}";
        $cacheTime = 10;

        return Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($id) {
            return Email::find($id);
        });
    }
}
