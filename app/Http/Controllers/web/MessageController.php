<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    //
    public function index(){
        return view('layouts.livestreamplayer.message');
    }
}
