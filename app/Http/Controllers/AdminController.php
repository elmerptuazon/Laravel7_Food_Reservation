<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Globals\Paymaya;

class AdminController extends Controller
{
    
    
    public function paymayaTest(Request $request) {
        $check = new Paymaya;
        return $check->paymayaCheckout($request->input('num'));
    } 
}
