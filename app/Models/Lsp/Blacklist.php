<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Base
{
    //
    protected $primaryKey = null;

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }
}
