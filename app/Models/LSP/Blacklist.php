<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Base
{
    //
    protected $primaryKey = '';

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }
}
