<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserEnabled
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
        if (Auth::check() && (int) Auth::user()->enabled !== 1) {
            // Force logout using the web guard explicitly
            Auth::guard('web')->logout();
            return redirect()->route('login')
                ->withErrors(['Your account has been disabled.']);
        }

        return $next($request);
    }
}
