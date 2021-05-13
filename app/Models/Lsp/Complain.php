<?php

namespace App\Models\Lsp;

class Complain extends Base
{
    //
    protected $table = 'complain';
    protected $primaryKey = 'id';

    public function song()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'ChannelCode', 'Code');
    }
}
