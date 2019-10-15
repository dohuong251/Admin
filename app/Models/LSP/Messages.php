<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Messages extends Base
{
    //
    protected $primaryKey = 'MessageId';

    public function sendUser()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'FromUserId');
    }

    public function receiveUser()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'ToUserId');
    }
}
