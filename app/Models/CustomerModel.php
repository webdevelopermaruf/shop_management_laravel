<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    public $table = "customers";
    public $primaryKey  = 'customer_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
    ];
}
