<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = [
        'customer_id',
        'total',
        'status',
        'shipping_address',
        'billing_address',
        'notes'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'shipping_address' => 'json',
        'billing_address' => 'json'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
