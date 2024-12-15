<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if(Auth::user()->is_super_admin || Auth::user()->role == 'admin' || Auth::user()->role == $role) {
            return $next($request);
        }
         abort(response()->json(['message' => "Invalid Role"], 403));
    }
}
