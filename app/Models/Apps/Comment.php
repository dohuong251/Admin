<?php

namespace App\Models\Apps;

class Comment extends Base
{
    //
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';

    public function appVersion()
    {
        return $this->belongsTo('App\Models\Apps\AppVersion', 'app_version_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Apps\User', 'user_id');
    }
}
