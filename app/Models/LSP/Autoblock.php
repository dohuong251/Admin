<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Autoblock extends Base
{
    //

    protected $primaryKey = ['Id'];

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'OwnerId');
    }
}
