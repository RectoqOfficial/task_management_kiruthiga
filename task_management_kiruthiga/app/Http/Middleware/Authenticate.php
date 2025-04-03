<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Redirect employees to their login page
            if ($request->is('employee/*')) {
                return route('employee.login'); // Ensure this route exists
            }
            // Default redirect for all others
            return route('login'); 
        }
    }
}
