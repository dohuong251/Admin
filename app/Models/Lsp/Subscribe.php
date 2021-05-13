<?php

namespace App\Models\Lsp;

class Subscribe extends Base
{
    //
    protected $primaryKey = ['UserId', 'TargetUserId'];
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function targetUser()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'TargetUserId');
    }
}
