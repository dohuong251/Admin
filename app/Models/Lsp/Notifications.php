<?php

namespace App\Models\Lsp;

class Notifications extends Base
{
    //
    protected $primaryKey = 'Id';

    public function sendUser()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'SenderId');
    }

    public function receiveUser()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'ReceiverId');
    }
}
