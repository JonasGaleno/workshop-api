<?php

namespace App\Models\People;

use App\Models\Company\Company;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';
    protected $fillable = [
        'name',
        'fantasy_name',
        'business_name',
        'person_type',
        'cpf_cnpj',
        'ie_rg',
        'birth_date',
        'created_by',
        'updated_by',
        'deleted_by',
        'company_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    protected static function booted()
    {
        static::saved(function ($people) {
            Cache::forget("person_{$people->id}");
            Cache::tags(['people'])->flush();
        });

        static::deleted(function ($people) {
            Cache::forget("person_{$people->id}");
            Cache::tags(['people'])->flush();
        });
    }
}
