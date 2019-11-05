<?php
namespace App\Models\APPS;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    //
    protected $connection = 'mysql_mdc_apps_connection';
    public $timestamps = false;
}
