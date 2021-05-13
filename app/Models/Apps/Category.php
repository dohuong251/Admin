<?php

namespace App\Models\Apps;

class Category extends Base
{
    //
    protected $table = 'category';
    protected $primaryKey = 'category_id';

    public function apps()
    {
        return $this->hasMany('App\Models\Apps\Apps', 'category_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function childCategory()
    {
        return $this->hasOne(Category::class, 'parent_category_id');
    }
}
