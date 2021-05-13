<?php

namespace App\Models\Ustv;

class Url extends Base
{
    //
    protected $table = "urls";
    protected $fillable = ['url', 'priority', 'cache_video', 'website'];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'id_channel');
    }
}
