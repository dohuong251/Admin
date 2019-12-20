<?php

namespace App\Models\Ustv;

use Illuminate\Database\Eloquent\Model;

class TypeTv extends Base
{
    //
    protected $table = "type_tv";

    public function category()
    {
        return $this->hasMany(Category::class, 'id_type_tv');
    }

    public function channel()
    {
        return $this->hasMany(Channel::class, 'id_type_tv');
    }

    public function channelBlacklist()
    {
        return $this->hasMany(ChannelBlacklist::class, 'id_type_tv');
    }

    public function updateTv()
    {
        return $this->hasMany(UpdateTv::class, 'id_type_tv');
    }
}
