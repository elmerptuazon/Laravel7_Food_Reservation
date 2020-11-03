<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = Auth::user()->role; 
        switch ($role) {
          case 'customer':
            return redirect('/');
            break;
      
          default:
            return $next($request);
          break;
        }
        
    }
}
