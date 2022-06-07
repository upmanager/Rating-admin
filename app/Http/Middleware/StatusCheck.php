<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class StatusCheck
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
        if(Auth::user()->status != 1) {
            $message = Auth::user()->status == 0 ? "Your account pending, wait to approve by admin" : "Your account blocked, contact to supprt support@rating.com";
            Auth::logout();
            return redirect()->route('login')->withErrors(['error' => $message]);
        }
        return $next($request);
    }
}
