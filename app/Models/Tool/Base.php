<?php

namespace App\Models\Tool;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    //
    protected $connection = 'mysql_tool_connection';
    public $timestamps = false;
}
