<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $connection = 'mysql_lsp_connection';
    public $timestamps = false;
}
