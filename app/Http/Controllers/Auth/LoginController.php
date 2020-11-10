<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo() {
        $role = Auth::user()->role; 

        if(Route::has('/payment')) {
          return '/payment';
        }
        
        switch ($role) {
          case 'admin':
            return '/admin/order';
            break;
          case 'customer':
            // dd(URL::previous());
            // dd($_SERVER['HTTP_REFERER'] == $_SERVER['HTTP_ORIGIN'] . '/payment');
            if($_SERVER['HTTP_REFERER'] == $_SERVER['HTTP_ORIGIN'] . '/payment') {
              return '/payment';
              break;
            }else {
              return '/';
              break; 
            }

          default:
            return '/';
          break;
        }
      }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
}
