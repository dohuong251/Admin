<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Autoblock extends Base
{
    //

    protected $primaryKey = ['Id'];

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'OwnerId');
    }
}
