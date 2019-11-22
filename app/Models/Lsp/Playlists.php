<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Playlists extends Base
{
    //
    protected $primaryKey = 'PlaylistId';

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId', 'UserId');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Lsp\Likes', 'TargetId');
    }

    public function playlistSongs(){
        return $this->hasMany('App\Models\Lsp\Playlistsongs','PlaylistId');
    }
}
