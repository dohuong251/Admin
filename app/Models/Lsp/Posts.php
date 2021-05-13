<?php

namespace App\Models\Lsp;

class Posts extends Base
{
    //
    protected $primaryKey = 'PostId';

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Lsp\Groups', 'GroupId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'StreamId');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Lsp\PostLikes', 'TargetId');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Lsp\Comments', 'TargetId');
    }
}
