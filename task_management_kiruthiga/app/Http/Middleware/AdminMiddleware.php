<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
   public function handle($request, Closure $next)
{
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Please login to access this page.');
    }

    if (strcasecmp(Auth::user()->role->name, 'admin') !== 0) {
        Auth::logout(); // Ensure unauthorized users are logged out
        return redirect('/login')->with('error', 'Unauthorized Access!');
    }

    return $next($request);
}
}

