<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $table = 'roles';
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users', 'role_id', 'user_id')
                    ->withTimestamps()
                    ->withPivot('created_by');
    }

    public function permissions()
    {
        return $this->belongsToMany(User::class, 'permissions_roles', 'role_id', 'permission_id')
                    ->withTimestamps()
                    ->withPivot('created_by');
    }
}
