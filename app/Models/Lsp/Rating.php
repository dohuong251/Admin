<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Rating extends Base
{
    //
    protected $primaryKey = ['UserId', 'SongId'];

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\Rating\Songs', 'SongId');
    }
}