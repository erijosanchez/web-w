<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomReport extends Model
{
    protected $fillable = [
        'name',
        'type',
        'parameters',
        'schedule',
        'created_by'
    ];

    protected $casts = [
        'parameters' => 'json'
    ];

    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }
}
