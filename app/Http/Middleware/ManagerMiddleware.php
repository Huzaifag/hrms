<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
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
        if($userRole == 2){
            return $next($request);
        }
        if($userRole == 1){
            return redirect()->route('admin.dashboard');
        }
        if($userRole == 3){
            return redirect()->route('hr.dashboard');
        }
        if($userRole == 4){
            return redirect()->route('employee.dashboard');
        }
    }
}
