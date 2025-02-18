<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'admin_users';

    //Columnas de la tabla admin_users
    protected $fillable = 
    [
        'name', 
        'email', 
        'password', 
        'is_active', 
        'last_login'
    ];

    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        // Actualiza last_login cada vez que el modelo se actualiza
        static::updating(function ($adminUser) {
            if ($adminUser->isDirty('last_login')) {
                $adminUser->last_login = Carbon::now();
            }
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role', 'admin_id', 'role_id');
    }
}
