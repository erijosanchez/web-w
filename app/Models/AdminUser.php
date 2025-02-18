<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, BelongsToMany, HasOne};
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $table =  'admin_user';

    //columnas de la tabla admin_user
    protected $fillable = 
    [
        'name',
        'email',
        'password',
        'is_active',
        'last_login'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'admin_role');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'created_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'admin_id');
    }

    public function customReports()
    {
        return $this->hasMany(CustomReport::class, 'created_by');
    }
}
