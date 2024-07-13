<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    public $table = "products";
    public $primaryKey  = 'product_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;

    public $fillable = [
        'product_name',
        'product_category',
        'product_barcode',
        'product_sku',
        'product_qty',
        'product_sold',
        'product_purchase_price',
        'product_sell_price'
    ];
}
