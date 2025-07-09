<?php

namespace App\Models\Company;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalCertification extends Model
{
    use HasFactory;

    protected $table = 'digital_certifications';
    protected $fillable = [
        'description',
        'certificate_file',
        'password',
        'cnpj',
        'valid_from',
        'valid_until',
        'is_active',
        'created_by',
        'updated_by',
        'company_id',
    ];
    protected $hidden = [
        'password',
        'certificate_file',
    ];

    protected function casts(): array
    {
        return [
            'certificate_file' => 'hashed',
            'password' => 'hashed',
        ];
    }

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
