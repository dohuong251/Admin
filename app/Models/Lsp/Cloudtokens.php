<?php

namespace App\Models\Lsp;

class Cloudtokens extends Base
{
    //
    protected $primaryKey = ['AppId', 'Provider', 'UDID'];
    public $incrementing = false;

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }
}
