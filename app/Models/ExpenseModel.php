<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseModel extends Model
{
    use HasFactory;
    public $table = "expenses";
    public $primaryKey  = 'expenses_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;

    protected $fillable = [
        'expenses_name',
        'expenses_type',
        'expenses_amount',
        'expenses_date',

    ];
}
