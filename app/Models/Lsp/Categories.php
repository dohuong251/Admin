<?php

namespace App\Models\Lsp;

class Categories extends Base
{
    //
    protected $primaryKey = 'CategoryId';

    public function songs()
    {
        return $this->hasMany('App\Models\Lsp\Songs', 'CategoryId');
    }
}
