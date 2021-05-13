<?php

namespace App\Models\Apps;

class GCM extends Base
{
    //
    protected $table = 'gcm';
    protected $primaryKey = ['gcm_id', 'app_id'];
    public $incrementing = false;

    public function app()
    {
        return $this->belongsTo('App\Models\Apps\Apps', 'app_id');
    }

    public function platform()
    {
        return $this->belongsTo('App\Models\Apps\Platform', 'platform_id');
    }
}
