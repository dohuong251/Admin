<?php

namespace App\Models\APPS;

use Illuminate\Database\Eloquent\Model;

class Platform extends Base
{
    //
    protected $table = 'platform';
    protected $primaryKey = 'platform_id';

    public function appVersion()
    {
        return $this->hasMany('App\Models\APPS\AppVersion', 'platform_id');
    }

    public function gcm()
    {
        return $this->belongsTo('App\Models\APPS\GCM', 'platform_id');
    }
}
