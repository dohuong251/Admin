<?php

namespace App\Http\Controllers\lsp;

use App\Http\Controllers\Controller;
use App\Http\Controllers\mảng;

class AnalyticController extends Controller
{
    //
    public function index()
    {
        return view('lsp.analytic');
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
