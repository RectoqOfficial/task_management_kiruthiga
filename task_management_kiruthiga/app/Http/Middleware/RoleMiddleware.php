<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{public function handle(Request $request, Closure $next, $role)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    // Debugging: Check if role is loaded
    \Log::info('User Role:', ['role' => $user->role]);

    if (!$user->role) {
        return abort(403, 'Unauthorized - Role Not Found');
    }

    if (strtolower($user->role->role) !== strtolower($role)) {
        return abort(403, 'Unauthorized - Role Mismatch');
    }

    return $next($request);
}

}
