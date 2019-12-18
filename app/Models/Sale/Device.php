<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Model;

class Device extends Base
{
    //
    protected $primaryKey = ["OrderId", "IMEI"];
    public $incrementing = false;
    protected $table = "devices";

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderId');
    }
}
