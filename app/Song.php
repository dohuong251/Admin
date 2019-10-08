<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    //
    protected $connection = 'mysqllivestreamplayer';
    protected $table = 'songs';

    protected $primaryKey = 'SongId';

    public function Users(){
        return $this -> belongsTo('App\Users', 'UserId');
    }
}
