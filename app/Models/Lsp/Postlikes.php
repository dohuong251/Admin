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
//            0 => 'App\Models\LSP\Posts',
//            1 => 'App\Models\LSP\Comments'
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
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }

//    public function likeable()
//    {
//        return $this->morphTo();
//    }

    public function target()
    {
        if ($this->TargetType == 0) {
            return $this->belongsTo('App\Models\LSP\Posts', 'TargetId');
        } else if ($this->TargetType == 1) {
            return $this->belongsTo('App\Models\LSP\Comments', 'TargetId');
        }
    }
}
