<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LicenseController extends Controller
{
    //
    public function index(){

        return view('layouts.sales.license');
    }
}
