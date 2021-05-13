<?php

namespace App\Models\Ustv;

class ChannelCategory extends Base
{
    //
    protected $table = "channel_category";

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'id_channel');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
