<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_admin == false) {
            
            if (Auth::user()->is_approved == false) {
                Auth::logout();
                return back()->with('warning', 'Your account is pending, admin check your information');
            } elseif (Auth::user()->status == false) {
                Auth::logout();
                return back()->with('warning', 'Your account is blocked, please contact admin');
            } else {
                return $next($request);
            }
            
        } else {
            return Redirect()->route('login');
        }
    }
}
