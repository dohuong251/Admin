<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Base
{
    //
    protected $primaryKey = 'Id';

    public function sendUser()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'SenderId');
    }

    public function receiveUser()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'ReceiverId');
    }
}
