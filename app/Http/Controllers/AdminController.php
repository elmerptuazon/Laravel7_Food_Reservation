<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Globals\Paymaya;

class AdminController extends Controller
{
    
    
    public function loginIndex() {
        return view('auth.admin_login');
    }

    public function registerIndex() {
        return view('auth.admin_register');
    }
}
