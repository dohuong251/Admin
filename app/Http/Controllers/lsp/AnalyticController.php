<?php

namespace App\Http\Controllers\lsp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnalyticController extends Controller
{
    //
    public function index(){
        return view('lsp.analytic');
    }
}
