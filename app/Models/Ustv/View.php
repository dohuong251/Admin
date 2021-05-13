<?php

namespace App\Models\Ustv;

class View extends Base
{
    //
    protected $table = "views";
    protected $primaryKey = "url";

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'ChannelId');
    }
}
