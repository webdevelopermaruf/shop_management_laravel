<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnProductModel extends Model
{
    use HasFactory;
    public $table = "return_product";
    public $primaryKey  = 'rp_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;

    // public $fillable = [
    //     'rp_id',
    //     'ro_product_name',
    //     'ro_product_barcode',
    //     'return_qty',
    //     'pre_order_no',
    //     'rp_order_no',
    //     'rp_creation',
    // ];
}
