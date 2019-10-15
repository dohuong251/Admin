<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Posts extends Base
{
    //
    protected $primaryKey = 'PostId';

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\LSP\Groups', 'GroupId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\LSP\Songs', 'StreamId');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\LSP\PostLikes', 'TargetId');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\LSP\Comments', 'TargetId');
    }
}
