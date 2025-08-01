<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;

class UserController extends Controller
{
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Cierra sesión antes de borrar
        Auth::logout();

        // Borra usuario
        $user->delete();

        // Redirige con mensaje
        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
    }
}
