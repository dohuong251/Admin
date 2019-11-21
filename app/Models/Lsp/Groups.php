<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Groups extends Base
{
    //
    protected $primaryKey = 'GroupId';

    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

    public function groupSongs()
    {
        return $this->hasMany('App\Models\LSP\Groupsongs', 'GroupId');
    }

    public function groupUsers()
    {
        return $this->hasMany('App\Models\LSP\Groupusers', 'GroupId');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\LSP\Posts', 'GroupId');
    }

    public function userInGroup()
    {
        return $this->hasMany('App\Models\LSP\Useringroup', 'GroupId');
    }
}
