<?php

namespace App\Models\Service;

use App\Models\Company\Company;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable = [
        'description',
        'price_sale',
        'max_discount_perc',
        'duration',
        'type',
        'is_active',
        'company_id',
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

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function serviceTaxes()
    {
        return $this->hasMany(ServiceTax::class);
    }

    protected static function booted()
    {
        static::saved(function ($service) {
            Cache::forget("service_{$service->id}");
            Cache::tags(['services'])->flush();
        });

        static::deleted(function ($service) {
            Cache::forget("service_{$service->id}");
            Cache::tags(['services'])->flush();
        });
    }
}
