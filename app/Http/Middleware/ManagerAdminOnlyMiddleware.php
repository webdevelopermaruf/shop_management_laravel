<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManagerAdminOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->get('role') >= 2){
            return $next($request);
        }else{
            return redirect()->to('/not/permitted');
        }
    }
}
