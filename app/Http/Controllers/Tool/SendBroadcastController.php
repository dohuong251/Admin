<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;

class SendBroadcastController extends Controller
{
    //
    public function index()
    {
        return view('tools.send_broadcast');
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
