<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Comments extends Base
{
    //
    protected $primaryKey = 'CommentId';

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function target()
    {
        if ($this->TargetType == 0) {
            return $this->belongsTo('App\Models\Lsp\Posts', 'TargetId');
        } else if ($this->TargetType == 1) {
            return $this->belongsTo('App\Models\Lsp\Comments', 'TargetId');
        }
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Lsp\Likes', 'TargetId');
    }
}
