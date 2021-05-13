<?php

namespace App\Models\Lsp;

class Messages extends Base
{
    //
    protected $primaryKey = 'MessageId';

    public function sendUser()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'FromUserId');
    }

    public function receiveUser()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'ToUserId');
    }
}
