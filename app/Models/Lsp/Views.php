<?php

namespace App\Models\Lsp;

class Views extends Base
{
    //
    protected $primaryKey = 'SongId';

    public function song()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }
}
