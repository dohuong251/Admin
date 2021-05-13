<?php

namespace App\Models\Lsp;

class Likes extends Base
{
    //
    protected $primaryKey = ['UserId', 'Type', 'TargetId'];
    public $incrementing = false;
//    protected $appends = array('like_type');
//
//    public function getLikeTypeAttribute()
//    {
//        if ($this->Type == 0) {
//            return 'App\Models\Lsp\Playlists';
//        } else if ($this->Type == 1) {
//            return 'App\Models\Lsp\Songs';
//        }
//    }

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

//    public function target()
//    {
//        return $this->morphTo();
//    }

    public function target()
    {
        if ($this->Type == 0) {
            return $this->belongsTo('App\Models\Lsp\Playlists', 'TargetId');
        } else if ($this->Type == 1) {
            return $this->belongsTo('App\Models\Lsp\Songs', 'TargetId');
        }
    }
}
