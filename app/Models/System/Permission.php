<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    
    protected $table = 'permissions';
    protected $fillable = [
        'name',
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

    public function roles()
    {
        return $this->belongsToMany(User::class, 'permissions_roles', 'permission_id', 'role_id')
                    ->withTimestamps()
                    ->withPivot('created_by');
    }
}
