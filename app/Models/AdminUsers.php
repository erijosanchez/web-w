<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUsers extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'admin_users';
    
    protected $fillable = [
        'role_id',
        'username',
        'profile_img',
        'email',
        'phone',
        'password',
        'first_name',
        'last_name',
        'is_active'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected $dates = ['last_login'];

    public function role()
    {
        return $this->belongsTo(AdminRole::class, 'role_id');
    }

    public function hasPermission($permission)
    {
        return $this->role->hasPermission($permission);
    }

    public function hasAnyPermission(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    public function hasAllPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }
}
