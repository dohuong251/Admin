<?php

namespace App\Models\Ustv;

use Illuminate\Database\Eloquent\Model;

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
