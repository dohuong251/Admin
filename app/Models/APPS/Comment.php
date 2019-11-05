<?php

namespace App\Models\APPS;

use Illuminate\Database\Eloquent\Model;

class Comment extends Base
{
    //
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';

    public function appVersion()
    {
        return $this->belongsTo('App\Models\APPS\AppVersion', 'app_version_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\APPS\User', 'user_id');
    }
}
