<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {

        if (Auth::guard("admin")->check()) {
            return redirect('/admin/dashboard');
        }
        if(Auth::guard("doctor")->check()) {
            return redirect('/doctor/dashboard');
        }
        if(Auth::guard("hospital")->check()) {
            return redirect('/hospital/dashboard');
        }
        if(Auth::guard("diagnostic")->check()) {
            return redirect('/diagnostic/dashboard');
        }
        if(Auth::guard("ambulance")->check()) {
            return redirect('/ambulance/dashboard');
        }
        return $next($request);

    }
}
