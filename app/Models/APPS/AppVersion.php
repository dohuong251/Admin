<?php

namespace App\Models\APPS;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Base
{
    //
    protected $table = 'app_version';
    protected $primaryKey = 'app_version_id';

    public function appDownloadDays()
    {
        return $this->hasMany('App\Models\APPS\AppDownloadDay', 'app_version_id');
    }

    public function appResources()
    {
        return $this->hasMany('App\Models\APPS\AppResources', 'app_version_id');
    }

    public function app()
    {
        return $this->belongsTo('App\Models\APPS\Apps', 'app_id');
    }

    public function platform()
    {
        return $this->belongsTo('App\Models\APPS\Platform', 'platform_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\APPS\Comment', 'app_version_id');
    }
}
