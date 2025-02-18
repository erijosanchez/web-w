<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentItem extends Model
{
    protected $table = 'content_items';
    
    protected $fillable = [
        'section_id',
        'title',
        'content',
        'media_url',
        'sort_order',
        'status',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function section()
    {
        return $this->belongsTo(ContentSection::class);
    }
}
