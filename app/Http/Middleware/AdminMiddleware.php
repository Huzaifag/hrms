<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(!Auth::check()){
            return redirect()->route('login');
        }
        $userRole = Auth::user()->role;
        if($userRole == 1){
            return $next($request);
        }
        if($userRole == 2){
            return redirect()->route('manager.dashboard');
        }
        if($userRole == 3){
            return redirect()->route('hr.dashboard');
        }
        if($userRole == 4){
            return redirect()->route('employee.dashboard');
        }
    }
}
