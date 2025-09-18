<?php

namespace App\Models\People;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Email extends Model
{
    use HasFactory;

    protected $table = 'emails';
    protected $fillable = [
        'person_id',
        'description',
        'email',
        'main_contact',
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

    protected static function booted()
    {
        static::saved(function ($email) {
            Cache::forget("email_{$email->id}");
            Cache::tags(['emails'])->flush();
        });

        static::deleted(function ($email) {
            Cache::forget("email_{$email->id}");
            Cache::tags(['emails'])->flush();
        });
    }
}
