<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Model;

class Apps extends Base
{
    //
    protected $table = 'app';
    protected $primaryKey = 'app_id';

    public function category()
    {
        return $this->belongsTo('App\Models\APPS\Category', 'category_id');
    }

    public function appVersions()
    {
        return $this->hasMany('App\Models\APPS\AppVersion', 'app_id');
    }

    public function gcm()
    {
        return $this->belongsTo('App\Models\APPS\GCM', 'app_id');
    }

    public function userApp()
    {
        return $this->hasMany('App\Models\APPS\UserApp', 'app_id');
    }
}
