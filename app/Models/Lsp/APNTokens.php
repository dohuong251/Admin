<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class APNTokens extends Base
{
    //
    protected $primaryKey = '';
    public function users()
    {
        return $this->belongsTo('App\Models\LSP\Users', 'UserId');
    }
}
