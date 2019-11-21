<?php

namespace App\Http\Controllers\Lsp;

use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        return view('sales.subscription');
    }

    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return null;
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return null;
    }
}
