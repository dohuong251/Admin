<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

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
