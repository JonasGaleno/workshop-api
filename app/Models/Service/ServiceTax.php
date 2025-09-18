<?php

namespace App\Models\Service;

use App\Models\Sale\Tax;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Cache;

class ServiceTax extends Pivot
{
    protected $table = 'service_taxes';
    protected $fillable = [
        'tax_id',
        'service_id',
        'uf',
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

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    protected static function booted()
    {
        static::saved(function ($serviceTax) {
            Cache::forget("service_tax_{$serviceTax->id}");
            Cache::tags(['services_taxes'])->flush();
        });

        static::deleted(function ($serviceTax) {
            Cache::forget("service_tax_{$serviceTax->id}");
            Cache::tags(['services_taxes'])->flush();
        });
    }
}
