<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, BelongsToMany, HasOne};
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $table =  'admin_users';

    //columnas de la tabla admin_user
    protected $fillable = 
    [
        'name',
        'email',
        'password',
        'profile_photo_path', /** Agrega campo de foto de perfil referenciado en la base de datos */
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

    /** funcion agregada para la actualización de foto de perfil de administrador */

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return Storage::disk('public')->url($this->profile_photo_path);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
