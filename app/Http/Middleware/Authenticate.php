<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($role === 'admin' && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}