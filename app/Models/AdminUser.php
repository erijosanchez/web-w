<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'last_login'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Obtiene los roles del administrador a través de la tabla pivote admin_role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role', 'admin_id', 'role_id')
                    ->withTimestamps();
    }

    /**
     * Verifica si el administrador tiene un rol específico
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Verifica si el administrador tiene un permiso específico a través de sus roles
     */
    public function hasPermission($permissionName)
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissionName) {
                $query->where('name', $permissionName);
            })->exists();
    }

    /**
     * Asigna roles al administrador
     */
    public function assignRole($roleId)
    {
        if (!$this->roles()->where('role_id', $roleId)->exists()) {
            return $this->roles()->attach($roleId);
        }
        return false;
    }

    /**
     * Remueve roles del administrador
     */
    public function removeRole($roleId)
    {
        return $this->roles()->detach($roleId);
    }

    /**
     * Sincroniza los roles del administrador
     */
    public function syncRoles($roleIds)
    {
        return $this->roles()->sync($roleIds);
    }

    //logs de auditoria para los administradores 
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'admin_id');
    }
}
