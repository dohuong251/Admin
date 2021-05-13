<?php

namespace App\Models\Lsp;

class Songs extends Base
{
    protected $table = 'songs';
    protected $fillable = ['Name', 'UserId', 'Description', 'URL', 'PublishedDate', 'LastOnline', 'Code', 'Language', 'CategoryId'];

    protected $primaryKey = 'SongId';

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Lsp\Likes', 'TargetId');
    }

    public function playlistSongs()
    {
        return $this->hasMany('App\Models\Lsp\Playlistsongs', 'SongId');
    }

    public function icon()
    {
        return $this->hasOne('App\Models\Lsp\Icons', 'SongId');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Lsp\Posts', 'SongId');
    }

    public function feature()
    {
        return $this->hasOne('App\Models\Lsp\Features', 'SongId');
    }

    public function copyrightStreams()
    {
        return $this->hasMany('App\Models\Lsp\Copyrightstreams', 'SongId');
    }

    public function groupsongs()
    {
        return $this->hasMany('App\Models\Lsp\Groupsongs', 'SongId');
    }

    public function chats()
    {
        return $this->hasMany('App\Models\Lsp\Chats', 'StreamId');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Lsp\Categories', 'CategoryId');
    }

    public function view()
    {
        return $this->hasOne('App\Models\Lsp\Views', 'SongId');
    }

    public function complains()
    {
        return $this->hasMany('App\Models\Lsp\Complain', 'ChannelCode', 'Code');
    }

}
