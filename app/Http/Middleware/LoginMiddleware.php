<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class LoginMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        if(Session::has('auth.token')){
            return $next($request);
        }else{
            return redirect('auth/login');
        }
    }
}
