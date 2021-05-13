<?php

namespace App\Models\Ustv;

class ChannelBlacklist extends Base
{
    //
    protected $table = "channel_blacklist";

    public function typeTv()
    {
        return $this->belongsTo(TypeTv::class, 'id_type_tv');
    }
}
