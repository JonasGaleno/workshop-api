<?php

namespace App\Models\Company;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Company extends Model
{
    use HasFactory;
    
    protected $table = 'companies';
    protected $fillable = [
        'business_name',
        'fantasy_name',
        'cnpj',
        'registration_state_ie',
        'email',
        'number',
        'country',
        'city',
        'state',
        'uf',
        'postal_code',
        'address',
        'reference',
        'obs',
        'created_by',
        'updated_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function booted()
    {
        static::saved(function ($company) {
            Cache::forget("company_{$company->id}");
            Cache::tags(['companies'])->flush();
        });

        static::deleted(function ($company) {
            Cache::forget("company_{$company->id}");
            Cache::tags(['companies'])->flush();
        });
    }
}
