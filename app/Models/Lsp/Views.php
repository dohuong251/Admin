<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Views extends Base
{
    //
    protected $primaryKey = 'SongId';

    public function song()
    {
        return $this->belongsTo('App\Models\LSP\Songs', 'SongId');
    }
}
