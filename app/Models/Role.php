<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    public function admins()
    {
        return $this->belongsToMany(AdminUser::class, 'admin_role', 'role_id', 'admin_id')
                    ->using(AdminRole::class); // Especificamos que use nuestro modelo pivote
    }

    public function adminRoles()
    {
        return $this->hasMany(AdminRole::class, 'role_id');
    }

    // Método para obtener todos los administradores con este rol
    public function getActiveAdmins()
    {
        return $this->admins()
                    ->wherePivot('role_id', $this->id)
                    ->get();
    }
}
