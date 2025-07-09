<?php

namespace App\Models\People;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    protected $fillable = [
        'person_id',
        'description',
        'country',
        'city',
        'state',
        'uf',
        'postal_code',
        'address',
        'number',
        'reference',
        'obs',
        'main_address',
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

    public function people()
    {
        return $this->belongsTo(People::class, 'person_id');
    }
}
