<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        $roles = collect($role);
        if (Auth::user()->is_admin && $roles->contains('admin')) {
            return $next($request);
        }
        if (Auth::user()->is_agent && $roles->contains('agent')) {
            return $next($request);
        }
        Auth::logout();
        return redirect('/login')->with('status', 'Access Denied!');
    }
}
