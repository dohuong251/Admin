<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Model;

class PaypalPurchase extends Base
{
    //
    protected $primaryKey = "PaymentId";
    protected $table = "paypalpurchase";
}
