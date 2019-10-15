<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Playlistsongs extends Base
{
    //
    protected $primaryKey = '';

    public function playlists()
    {
        return $this->belongsTo('App\Models\LSP\Playlists', 'PlaylistId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\LSP\Songs', 'SongId');
    }
}
