<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Model;

class LicenseKey extends Base
{
    //
    protected $primaryKey = "LicenseId";
    protected $table="licensekey";

//    public function order()
//    {
//        if ($this->OrderId == -1) return null;
//        print_r(explode("-", $this->OrderId));
//        return $this->belongsTo(Order::class, 'OrderId')->whereIn('OrderId', explode("-", $this->OrderId))->limit(3);
//    }
}
