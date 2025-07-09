<?php

namespace App\Models\Service;

use App\Models\Company\Company;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
