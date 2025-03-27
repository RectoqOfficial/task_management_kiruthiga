<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role_id == 2) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Unauthorized Access!');
    }
}
