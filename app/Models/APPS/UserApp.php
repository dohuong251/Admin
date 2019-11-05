<?php

namespace App\Models\APPS;

use Illuminate\Database\Eloquent\Model;

class UserApp extends Base
{
    //
    protected $table = 'user_app';
    protected $primaryKey = 'user_app_id';

    public function user()
    {
        return $this->belongsTo('App\Models\APPS\User', 'user_id');
    }

    public function app()
    {
        return $this->hasMany('App\Models\APPS\Apps', 'app_id');
    }
}
