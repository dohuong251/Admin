<?php

namespace App\Models\Lsp;

class Rating extends Base
{
    //
    protected $primaryKey = ['UserId', 'SongId'];
    public $incrementing = false;

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }
}
