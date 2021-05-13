<?php

namespace App\Models\Lsp;

class Autoblock extends Base
{
    //

    protected $primaryKey = 'Id';

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'OwnerId');
    }
}
