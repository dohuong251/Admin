<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Views extends Base
{
    //
    protected $primaryKey = ['UserId', 'TargetUserId'];

    public function song()
    {
        return $this->belongsTo('App\Models\LSP\Songs', 'SongId');
    }
}
