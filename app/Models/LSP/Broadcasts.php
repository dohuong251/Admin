<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Broadcasts extends Base
{
    //

    protected $primaryKey = ['BroadcastId'];

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }
}
