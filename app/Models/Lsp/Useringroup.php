<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Useringroup extends Base
{
    //
    protected $primaryKey = ['GroupId', 'UserId'];

    public function user()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function group(){
        return $this->belongsTo('App\Models\Lsp\Groups','GroupId');
    }
}
