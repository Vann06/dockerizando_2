<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Manejar la solicitud entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !$request->user()->roles()->where('nombre', 'admin')->exists()) {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
}
