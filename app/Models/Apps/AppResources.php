<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Model;

class AppResources extends Base
{
    //
    protected $table = 'app_resources';
    protected $primaryKey = 'app_resources_id';
    protected $fillable = ['type', 'link'];

    public function appVersion()
    {
        return $this->belongsTo('App\Models\Apps\AppVersion', 'app_version_id');
    }
}
