<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Groupusers extends Base
{
    //
    protected $primaryKey = '';

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'OwnerId');
    }

    public function groups()
    {
        return $this->belongsTo('App\Models\LSP\Groups', 'GroupId');
    }
}
