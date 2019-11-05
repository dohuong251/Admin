<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Songs extends Base
{
    protected $table = 'songs';

    protected $primaryKey = 'SongId';

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\LSP\Likes', 'TargetId');
    }

    public function playlistSongs()
    {
        return $this->hasMany('App\Models\LSP\Playlistsongs', 'SongId');
    }

    public function icon()
    {
        return $this->hasOne('App\Models\LSP\Icons', 'SongId');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\LSP\Posts', 'SongId');
    }

    public function feature()
    {
        return $this->hasOne('App\Models\LSP\Features', 'SongId');
    }

    public function copyrightStreams()
    {
        return $this->hasMany('App\Models\LSP\Copyrightstreams', 'SongId');
    }

    public function groupsongs()
    {
        return $this->hasMany('App\Models\LSP\Groupsongs', 'SongId');
    }

    public function chats()
    {
        return $this->hasMany('App\Models\LSP\Chats', 'StreamId');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\LSP\Categories', 'CategoryId');
    }

    public function view()
    {
        return $this->hasOne('App\Models\LSP\Views', 'SongId');
    }

    public function complains()
    {
        return $this->hasMany('App\Models\LSP\Complain', 'ChannelCode', 'Code');
    }

}
