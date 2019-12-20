<?php

namespace App\Models\Ustv;

use Illuminate\Database\Eloquent\Model;

class Category extends Base
{
    //
    protected $table = "category";

    public function typeTv()
    {
        return $this->belongsTo(TypeTv::class, 'id_type_tv');
    }

    public function channelType()
    {
        return $this->belongsTo(ChannelType::class, 'id_channel_type');
    }

    public function channelCategory()
    {
        return $this->hasMany(ChannelCategory::class, 'id_category');
    }
}
