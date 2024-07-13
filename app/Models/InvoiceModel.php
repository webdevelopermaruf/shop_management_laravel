<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    use HasFactory;
    public $table = "invoice";
    public $primaryKey  = 'invoice_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;
}
