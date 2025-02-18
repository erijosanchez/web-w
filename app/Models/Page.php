<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = 
    [
        'title',
        'slug',
        'content',
        'meta_title',
        'mea_description',
        'status',
        'layout',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }

    
}
