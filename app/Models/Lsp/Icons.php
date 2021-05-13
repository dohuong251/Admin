<?php

namespace App\Models\Lsp;

class Icons extends Base
{
    //
    protected $primaryKey = null;

    public function songs()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }

}
