<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';

    protected $fillable = 
    [
        'name', 
        'description'
    ];

    //tabla de los permisos, relacion
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    //relacion con la los usaurios administradores
    public function adminUsers()
    {
        return $this->belongsToMany(AdminUser::class, 'admin_role', 'role_id', 'admin_id');
    }
}
