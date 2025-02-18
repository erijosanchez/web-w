<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    protected $fillable = [
        'session_id',
        'customer_id',
        'page_url',
        'referrer_url',
        'user_agent',
        'ip_address',
        'device_type'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
