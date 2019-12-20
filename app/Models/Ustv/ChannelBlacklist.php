<?php

namespace App\Models\Ustv;

use Illuminate\Database\Eloquent\Model;

class ChannelBlacklist extends Base
{
    //
    protected $table = "channel_blacklist";

    public function typeTv()
    {
        return $this->belongsTo(TypeTv::class, 'id_type_tv');
    }
}
