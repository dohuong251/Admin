<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Playlists extends Base
{
    //
    protected $primaryKey = 'PlaylistId';

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId', 'UserId');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\LSP\Likes', 'TargetId');
    }

    public function playlistSongs(){
        return $this->hasMany('App\Models\LSP\Playlistsongs','PlaylistId');
    }
}
