<?php

namespace App\Models\Ustv;

class ChannelType extends Base
{
    //
    protected $table = "channel_type";

    public function category()
    {
        return $this->hasMany(Category::class, 'id_type_tv');
    }
}
