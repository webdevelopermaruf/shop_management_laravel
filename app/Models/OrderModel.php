<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    public $table = "orders";
    public $primaryKey  = 'orders_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;

    protected $fillable = [
        'orders_holder',
        'orders_holder_phone',
        'orders_purchase_price',
        'orders_sell_price',
        'orders_discount_price',
        'orders_grand_price',
        'orders_creation',
    ];
}
