<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Features extends Base
{
    //
    protected $primaryKey = '';

    public function songs()
    {
        return $this->belongsTo('App\Models\LSP\Songs', 'SongId');
    }

    public function likes()
    {
        return $this->hasManyThrough('App\Models\LSP\Likes', 'App\Models\LSP\Songs', 'SongId', 'TargetId', 'SongId');
    }
}
