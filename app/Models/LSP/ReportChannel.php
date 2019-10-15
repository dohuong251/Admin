<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class ReportChannel extends Base
{
    //
    protected $primaryKey = ['ChannelId', 'ReportedUserId'];

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'ReportedUserId');
    }
}
