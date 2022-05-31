<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Redirect;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $role = Auth::check() ? Auth::user()->role : -1;
        // admin,worker,client
        if (in_array('admin', $roles) && $role == 0) {
            return $next($request);
        } else if (in_array('client', $roles) && $role == 1) {
            return $next($request);
        } else if (in_array('worker', $roles) && $role == 2) {
            return $next($request);
        }
        return Redirect::route('dashboard.index');
    }
}
