<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

//
//trait MorphMap
//{
//    protected static function boot()
//    {
//        static::bootTraits();
//
//        static::loadMorphMap();
//    }
//
//    protected static function loadMorphMap()
//    {
//        Relation::morphMap([
//            0 => 'App\Models\Lsp\Posts',
//            1 => 'App\Models\Lsp\Comments'
//        ]);
//    }
//}

class Postlikes extends Base
{
//    use MorphMap;
    //
    protected $primaryKey = '';

    public function users()
    {
        return $this->belongsTo('App\Models\Lsp\Users', 'UserId');
    }

//    public function likeable()
//    {
//        return $this->morphTo();
//    }

    public function target()
    {
        if ($this->TargetType == 0) {
            return $this->belongsTo('App\Models\Lsp\Posts', 'TargetId');
        } else if ($this->TargetType == 1) {
            return $this->belongsTo('App\Models\Lsp\Comments', 'TargetId');
        }
    }
}
