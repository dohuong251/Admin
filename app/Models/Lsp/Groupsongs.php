<?php

namespace App\Models\Lsp;

class Groupsongs extends Base
{
    //
    protected $primaryKey = null;

    public function groups()
    {
        return $this->belongsTo('App\Models\Lsp\Groups', 'GroupId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }
}
