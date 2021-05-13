<?php

namespace App\Models\Lsp;

class Groupusers extends Base
{
    //
    protected $primaryKey = null;

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'OwnerId');
    }

    public function groups()
    {
        return $this->belongsTo('App\Models\Lsp\Groups', 'GroupId');
    }
}
