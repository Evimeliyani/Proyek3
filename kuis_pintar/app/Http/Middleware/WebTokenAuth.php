<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('auth_token')) {
            return redirect()->route('web.login')->with('error', 'Silakan login dulu.');
        }

        return $next($request);
    }
}
