<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_roles';
    
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(AdminPermisos::class, 'role_permissions', 'role_id', 'permission_id')
                    ->using(RolePermissions::class);
    }

    public function adminUsers()
    {
        return $this->hasMany(AdminUsers::class, 'role_id');
    }

    // Métodos útiles para manejar permisos
    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = AdminPermisos::where('slug', $permission)->firstOrFail();
        }
        
        if ($this->permissions->contains($permission)) {
            return $this;
        }
        
        $this->permissions()->attach($permission);
        
        return $this;
    }

    public function withdrawPermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = AdminPermisos::where('slug', $permission)->firstOrFail();
        }

        $this->permissions()->detach($permission);

        return $this;
    }

    public function updatePermissions(array $permissions)
    {
        $permissionIds = collect($permissions)->map(function ($permission) {
            if (is_numeric($permission)) {
                return $permission;
            }
            return AdminPermisos::where('slug', $permission)->firstOrFail()->id;
        });

        $this->permissions()->sync($permissionIds);

        return $this;
    }

    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('slug', $permission);
        }
        
        return $this->permissions->contains($permission);
    }
}
