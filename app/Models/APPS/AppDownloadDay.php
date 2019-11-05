<?php

namespace App\Models\APPS;

use Illuminate\Database\Eloquent\Model;

class AppDownloadDay extends Base
{
    //
    protected $table = 'app_download_day';
    protected $primaryKey = 'app_download_day_id';

    public function appVersion()
    {
        return $this->belongsTo('App\Models\APPS\AppVersion', 'app_version_id');
    }
}
