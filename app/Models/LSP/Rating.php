<?php

namespace App\Models\LSP;

use Illuminate\Database\Eloquent\Model;

class Rating extends Base
{
    //
    protected $primaryKey = ['UserId', 'SongId'];

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\Rating\Songs', 'SongId');
    }
}
