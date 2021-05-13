<?php

namespace App\Models\Apps;

class Apps extends Base
{
    //
    protected $table = 'app';
    protected $primaryKey = 'app_id';

    public function category()
    {
        return $this->belongsTo('App\Models\Apps\Category', 'category_id');
    }

    public function appVersions()
    {
        return $this->hasMany('App\Models\Apps\AppVersion', 'app_id');
    }

    public function gcm()
    {
        return $this->hasMany('App\Models\Apps\GCM', 'app_id');
    }

    public function userApp()
    {
        return $this->hasMany('App\Models\Apps\UserApp', 'app_id');
    }
}
