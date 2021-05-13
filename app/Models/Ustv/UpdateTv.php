<?php

namespace App\Models\Ustv;

class UpdateTv extends Base
{
    //
    protected $table = "update_tv";

    public function typeTv()
    {
        return $this->hasMany(TypeTv::class, 'id_type_tv');
    }
}
