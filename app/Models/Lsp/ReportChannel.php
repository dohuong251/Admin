<?php

namespace App\Models\Lsp;

class ReportChannel extends Base
{
    //
    protected $primaryKey = ['ChannelId', 'ReportedUserId'];
    public $incrementing = false;

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'ReportedUserId');
    }
}
