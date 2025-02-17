<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_role';

    // Permitir asignación masiva si es necesario
    protected $fillable = [
        'admin_id',
        'role_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'permission_role', 'role_id', 'permission_id');
    }

    public function admins()
    {
        return $this->belongsToMany(AdminUser::class, 'admin_role', 'role_id', 'admin_id');
    }

    public function assignPermission($permissionId)
    {
        if (!$this->permissions()->where('permission_id', $permissionId)->exists()) {
            return $this->permissions()->attach($permissionId);
        }
        return false;
    }

    public function removePermission($permissionId)
    {
        return $this->permissions()->detach($permissionId);
    }

    public function syncPermissions($permissionIds)
    {
        return $this->permissions()->sync($permissionIds);
    }

    // Deshabilitamos timestamps si la tabla no los tiene
    public $timestamps = false;

    public function admin()
    {
        return $this->belongsTo(AdminUser::class, 'admin_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
