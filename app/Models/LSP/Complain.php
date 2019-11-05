<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Complain extends Base
{
    //
    protected $table = 'complain';
    protected $primaryKey = 'id';

    public function song()
    {
        return $this->belongsTo('App\Models\LSP\Songs', 'ChannelCode', 'Code');
    }
}
