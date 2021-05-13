<?php

namespace App\Models\Lsp;

class Copyrightstreams extends Base
{
    //
    protected $primaryKey = 'Id';

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
