<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Likes extends Base
{
    //
    protected $primaryKey = ['UserId', 'Type', 'TargetId'];
//    protected $appends = array('like_type');
//
//    public function getLikeTypeAttribute()
//    {
//        if ($this->Type == 0) {
//            return 'App\Models\LSP\Playlists';
//        } else if ($this->Type == 1) {
//            return 'App\Models\LSP\Songs';
//        }
//    }

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

//    public function target()
//    {
//        return $this->morphTo();
//    }

    public function target()
    {
        if ($this->Type == 0) {
            return $this->belongsTo('App\Models\LSP\Playlists', 'TargetId');
        } else if ($this->Type == 1) {
            return $this->belongsTo('App\Models\LSP\Songs', 'TargetId');
        }
    }
}
