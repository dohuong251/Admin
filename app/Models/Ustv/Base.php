<?php

namespace App\Models\Ustv;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    //
    protected $connection = 'mysql_ustv_connection';
    public $timestamps = false;
}
