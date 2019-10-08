<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    //
    public function index(){

        return view('layouts.tools.notification');
    }
}
