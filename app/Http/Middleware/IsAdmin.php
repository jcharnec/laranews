<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Bloquea si no hay usuario o no tiene el rol "administrador"
        if (!$user || !$user->hasRole('administrador')) {
            abort(403, 'Operación solamente para el administrador.');
        }

        return $next($request);
    }
}
