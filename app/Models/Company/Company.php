<?php

namespace App\Models\Company;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
