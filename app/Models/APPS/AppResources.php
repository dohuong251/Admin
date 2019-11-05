<?php

namespace App\Models\APPS;

use Illuminate\Database\Eloquent\Model;

class AppResources extends Base
{
    //
    protected $table = 'app_resources';
    protected $primaryKey = 'app_resources_id';

    public function appVersion()
    {
        return $this->belongsTo('App\Models\APPS\AppVersion', 'app_version_id');
    }
}
