<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Playlistsongs extends Base
{
    //
    protected $primaryKey = null;

    public function playlists()
    {
        return $this->belongsTo('App\Models\Lsp\Playlists', 'PlaylistId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }
}
