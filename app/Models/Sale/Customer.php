<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Model;

class Customer extends Base
{
    //
    protected $primaryKey = "CustomerId";
    protected $table = "customers";

    public function order()
    {
        return $this->hasMany(Order::class, 'CustomerId');
    }
}
