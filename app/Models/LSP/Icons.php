<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Icons extends Base
{
    //
    protected $primaryKey = '';

    public function songs()
    {
        return $this->belongsTo('App\Models\LSP\Songs', 'SongId');
    }

}
