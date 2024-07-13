<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminlogModel extends Model
{
    use HasFactory;
    
    public $table = "adminlog";
    public $primaryKey  = 'admin_no';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;
}
