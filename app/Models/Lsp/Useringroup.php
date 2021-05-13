<?php

namespace App\Models\Lsp;

class Useringroup extends Base
{
    //
    protected $primaryKey = ['GroupId', 'UserId'];
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Lsp\Groups', 'GroupId');
    }
}
