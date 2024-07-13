<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    public $table = "categories";
    public $primaryKey  = 'category_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;
}
