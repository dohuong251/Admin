<?php

namespace App\Models\Lsp;

class Broadcasts extends Base
{
    //

    protected $primaryKey = 'BroadcastId';

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }
}
