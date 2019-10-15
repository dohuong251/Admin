<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $connection = 'mysql_lsp_connection';
    public $timestamps = false;
}
