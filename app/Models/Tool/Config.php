<?php

namespace App\Models\Tool;

class Config extends Base
{
    //
    protected $table = 'config';
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = ['value'];
}
