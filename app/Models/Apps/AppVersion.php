<?php

namespace App\Models\Apps;

class AppVersion extends Base
{
    //
    protected $table = 'app_version';
    protected $primaryKey = 'app_version_id';

    protected $guarded = [];
    public $timestamps = true;
    public const UPDATED_AT = 'last_update';
    public const CREATED_AT = 'create_time';

    public function appDownloadDays()
    {
        return $this->hasMany('App\Models\Apps\AppDownloadDay', 'app_version_id');
    }

    public function appResources()
    {
        return $this->hasMany('App\Models\Apps\AppResources', 'app_version_id');
    }

    public function app()
    {
        return $this->belongsTo('App\Models\Apps\Apps', 'app_id');
    }

    public function platform()
    {
        return $this->belongsTo('App\Models\Apps\Platform', 'platform_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Apps\Comment', 'app_version_id');
    }
}
