<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::check() && Auth::user()->rol === $role) {
            return $next($request);
        }

        abort(403, 'No tienes permisos para acceder.');
    }
}
