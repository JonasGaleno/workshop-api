<?php

namespace App\Models\Company;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    
    protected $table = 'employees';
    protected $fillable = [
        'name',
        'expertise',
        'cnpj',
        'service_comission_perc',
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
        return $this->belongsTo(Company::class);
    }
}
