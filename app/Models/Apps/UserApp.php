<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Model;

class UserApp extends Base
{
    //
    protected $table = 'user_app';
    protected $primaryKey = 'user_app_id';

    public function user()
    {
        return $this->belongsTo('App\Models\Apps\User', 'user_id');
    }

    public function app()
    {
        return $this->hasMany('App\Models\Apps\Apps', 'app_id');
    }
}
