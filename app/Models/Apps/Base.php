<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    //
    protected $connection = 'mysql_mdc_apps_connection';
    public $timestamps = false;
}
