<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Comments extends Base
{
    //
    protected $primaryKey = 'CommentId';

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

    public function target()
    {
        if ($this->TargetType == 0) {
            return $this->belongsTo('App\Models\LSP\Posts', 'TargetId');
        } else if ($this->TargetType == 1) {
            return $this->belongsTo('App\Models\LSP\Comments', 'TargetId');
        }
    }

    public function likes()
    {
        return $this->hasMany('App\Models\LSP\Likes', 'TargetId');
    }
}
