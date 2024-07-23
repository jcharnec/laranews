<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as FacadesRoute;

class IsBlocked
{
    //CONFIGURABLE: nombre de rutas web permitidas para los usuarios bloqueados
    //podríamos sacarlas hacia el fichero de configuración (p.e.:/config/users.php)
    //permitiremos las operaciones de contacto, logout y user.blocked (evita loop)
    protected $allowed = ['contacto', 'contacto.email', 'user.blocked', 'logout'];

    //maneja la petición entrante
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $ruta = FacadesRoute::currentRouteName();

        // si hay usuario, está bloqueado e intenta acceder a una ruta no permitida, 
        // le llevamos a la ruta de bloqueo
        if ($user && $user->hasRole('bloqueado') && !in_array($ruta, $this->allowed))
            return redirect()->route('user.blocked');

        return $next($request);
    }
}
