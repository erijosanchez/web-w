<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentSection extends Model
{
    protected $table = "content_sections";

    protected $fillable = [
        'name',
        'identifier',
        'type',
        'status'
    ];

    public function contentItems()
    {
        return $this->hasMany(ContentItem::class, 'section_id');
    }
}
