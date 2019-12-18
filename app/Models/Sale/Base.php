<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    //
    protected $connection = 'mysql_sale_connection';
    public $timestamps = false;
}
