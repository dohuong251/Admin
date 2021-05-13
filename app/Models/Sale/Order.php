<?php

namespace App\Models\Sale;

class Order extends Base
{
    //
    protected $primaryKey = "OrderId";
    protected $table = "orders";

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerId');
    }

    public function licenseKey()
    {
        return $this->hasMany(LicenseKey::class, 'OrderId')->where('LicenseKey', 'regexp', "(.*?-)?$this->OrderId(-.*)?");
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'OrderId');
    }

    public function device()
    {
        return $this->hasMany(Device::class, 'OrderId');
    }
}
