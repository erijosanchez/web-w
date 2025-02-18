<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
