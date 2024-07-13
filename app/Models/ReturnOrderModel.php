<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrderModel extends Model
{
    use HasFactory;
    public $table = "return_order";
    public $primaryKey  = 'ro_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;

    // public $fillable = [
    //     'ro_id',
    //     'ro_cus_name',
    //     'ro_cus_phone',
    //     'pre_order_no',
    //     'exchange_order_no',
    //     'ro_qty',
    //     'ro_money',
    //     'ro_creation'
    // ];
}
