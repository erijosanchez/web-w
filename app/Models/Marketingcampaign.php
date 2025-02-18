<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketingcampaign extends Model
{
    protected $table = 'marketing_campaigns';
    
    protected $fillable = [
        'name',
        'type',
        'status',
        'start_date',
        'end_date',
        'settings'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'settings' => 'json'
    ];

}
