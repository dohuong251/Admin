<?php

namespace App\Models\Sale;

class Subscription extends Base
{
    //
    protected $primaryKey = "SubscriptionID";
    protected $table = "subscriptions";

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderId');
    }
}
