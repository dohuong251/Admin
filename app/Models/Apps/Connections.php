<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Model;

class Connections extends Model
{
    protected $connection = 'mysql_tool_connection';
    protected $primaryKey = "id";
    protected $table = 'connections';
}
