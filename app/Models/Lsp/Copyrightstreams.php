<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Copyrightstreams extends Base
{
    //
    //protected $primaryKey = 'CommentId';

    // user phát stream bị report
    public function reportedUsers()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    // user report stream
    public function reporter()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'OwnerId');
    }

    public function songs()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }
}
