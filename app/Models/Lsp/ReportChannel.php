<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class ReportChannel extends Base
{
    //
    protected $primaryKey = ['ChannelId', 'ReportedUserId'];

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'ReportedUserId');
    }
}
