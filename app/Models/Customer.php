<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, BelongsToMany, HasOne};

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = 
    [
        'name', 
        'email', 
        'password', 
        'plan', 
        'status', 
        'last_login'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = 
    [
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    //Relacion con la tabla de orden o pedido
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    //mantiene la relación con el carrito de compras
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function pageVisits()
    {
        return $this->hasMany(PageVisit::class);
    }
}
