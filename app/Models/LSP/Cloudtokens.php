<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Cloudtokens extends Base
{
    //
    protected $primaryKey = ['AppId', 'Provider', 'UDID'];

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }
}
