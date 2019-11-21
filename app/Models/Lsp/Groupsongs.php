<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Groupsongs extends Base
{
    //
    protected $primaryKey = '';

    public function groups()
    {
        return $this->belongsTo('App\Models\LSP\Groups', 'GroupId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\LSP\Songs', 'SongId');
    }
}
