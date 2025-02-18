<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StyleSetting extends Model
{
    protected $fillable = [
        'category',
        'settings',
        'is_active'
    ];

    protected $casts = [
        'settings' => 'json',
        'is_active' => 'boolean'
    ];
}
