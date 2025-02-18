<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = 
    [
        'name', 
        'description', 
        'category'
    ];

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'permission_role', 'permission_id', 'role_id');
    }
}
