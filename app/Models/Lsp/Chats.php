<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Chats extends Base
{
    //
    protected $primaryKey = 'ChatId';

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

    public function songs()
    {
        return $this->belongsTo('APp\Models\LSP\Songs', 'StreamId');
    }
}
