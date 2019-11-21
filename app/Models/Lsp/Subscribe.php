<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Base
{
    //
    protected $primaryKey = ['UserId', 'TargetUserId'];

    public function user()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

    public function targetUser()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'TargetUserId');
    }
}
