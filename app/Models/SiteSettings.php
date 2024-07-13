<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    use HasFactory;
    public $table = "sitesettings";
    public $primaryKey  = 'site_id';
    public $keyType  = 'int';
    public $incremeting = true;
    public $timestamps  = false;

}
