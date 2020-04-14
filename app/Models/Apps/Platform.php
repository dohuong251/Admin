<?php

namespace App\Models\Apps;

use Illuminate\Database\Eloquent\Model;

class Platform extends Base
{
    //
    protected $table = 'platform';
    protected $primaryKey = 'platform_id';

    public function appVersion()
    {
        return $this->hasMany('App\Models\Apps\AppVersion', 'platform_id');
    }

    public function gcm()
    {
        return $this->belongsTo('App\Models\Apps\GCM', 'platform_id');
    }
}
