<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Model;

class User extends Base
{
    //
    protected $table = 'user';
    protected $primaryKey = 'user_id';

    public function comments()
    {
        return $this->belongsTo('App\Models\Apps\Comment', 'user_id');
    }

    public function userApp()
    {
        return $this->belongsTo('App\Models\Apps\UserApp', 'user_id');
    }
}
