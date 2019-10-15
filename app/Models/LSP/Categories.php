<?php

namespace App\Models\LSP;

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
