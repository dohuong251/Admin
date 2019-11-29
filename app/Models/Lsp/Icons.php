<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Icons extends Base
{
    //
    protected $primaryKey = null;

    public function songs()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }

}
