<?php

namespace App\Models\Lsp;

class Blacklist extends Base
{
    //
    protected $primaryKey = null;

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }
}
