<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Base
{
    //
    protected $table = 'app_version';
    protected $primaryKey = 'app_version_id';
    protected $fillable = ['platform_id', 'platform_id', 'icon_url', 'app_version_name', 'app_version_subname', 'package_name', 'version_name', 'size', 'ads_image', 'download_url', 'last_update', 'create_time', 'playstoreURL', 'appleUrl', 'amazoneUrl', 'portableUrl', 'requires', 'portuguese_requires', 'what_new', 'description', 'portuguese_what_new', 'portuguese_description'];
    public $timestamps = true;
    public const UPDATED_AT = 'last_update';
    public const CREATED_AT = 'create_time';

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
