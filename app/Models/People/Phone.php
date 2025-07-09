<?php

namespace App\Models\People;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $table = 'phones';
    protected $fillable = [
        'person_id',
        'description',
        'number',
        'main_number',
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
