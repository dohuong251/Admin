<?php

namespace App\Models\Lsp;

class Features extends Base
{
    //
    protected $primaryKey = null;

    public function songs()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }

    public function likes()
    {
        return $this->hasManyThrough('App\Models\Lsp\Likes', 'App\Models\Lsp\Songs', 'SongId', 'TargetId', 'SongId');
    }
}
