<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Categories extends Base
{
    //
    protected $primaryKey = 'CategoryId';

    public function songs()
    {
        return $this->hasMany('App\Models\LSP\Songs', 'CategoryId');
    }
}
