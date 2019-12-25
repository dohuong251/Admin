<?php

namespace App\Models\Ustv;

use Illuminate\Database\Eloquent\Model;

class Channel extends Base
{
    //
    protected $table = "channels";
    protected $fillable = ["symbol", "description", "icon_name", "id_type_tv"];

    public function typeTv()
    {
        return $this->belongsTo(TypeTv::class, 'id_type_tv');
    }

    public function channelCategory()
    {
        return $this->hasMany(ChannelCategory::class, 'id_channel');
    }

    public function url()
    {
        return $this->hasMany(Url::class, 'id_channel');
    }

    public function view()
    {
        return $this->hasMany(View::class, 'ChannelId');
    }
}
