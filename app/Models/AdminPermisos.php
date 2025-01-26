<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermisos extends Model
{
    protected $table = 'admin_permissions';
    
    protected $fillable = ['name', 'slug', 'description'];
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'role_permissions', 'permission_id', 'role_id');
    }
}
