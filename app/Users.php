<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //
    protected $connection = 'mysqllivestreamplayer';
    protected $table = 'users';

    public $timestamps = false;

    protected $primaryKey = 'UserId';



    public function Songs(){
        return $this -> hasMany('App\Song', 'UserId', 'UserId');
    }

}
