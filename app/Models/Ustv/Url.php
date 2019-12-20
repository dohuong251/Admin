<?php

namespace App\Models\Ustv;

use Illuminate\Database\Eloquent\Model;

class Url extends Base
{
    //
    protected $table = "urls";

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'id_channel');
    }
}
