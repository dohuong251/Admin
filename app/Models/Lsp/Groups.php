<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class Groups extends Base
{
    //
    protected $primaryKey = 'GroupId';

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

    public function groupSongs()
    {
        return $this->hasMany('App\Models\Lsp\Groupsongs', 'GroupId');
    }

    public function groupUsers()
    {
        return $this->hasMany('App\Models\Lsp\Groupusers', 'GroupId');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Lsp\Posts', 'GroupId');
    }

    public function userInGroup()
    {
        return $this->hasMany('App\Models\Lsp\Useringroup', 'GroupId');
    }
}
