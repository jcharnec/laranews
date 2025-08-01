<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Prevenir que un admin se borre a sí mismo (opcional: puedes usar roles si tienes más lógica)
        if (Auth::id() === 1) {
            return back()->with('error', 'No puedes eliminar tu cuenta de administrador principal.');
        }

        // Cierra sesión antes de borrar
        Auth::logout();

        // Borra imagen si existe
        if ($user->imagen && Storage::disk('public')->exists('images/users/' . $user->imagen)) {
            Storage::disk('public')->delete('images/users/' . $user->imagen);
        }

        // Borra el usuario (soft delete si lo tienes habilitado)
        $user->delete();

        // Redirige a la home con mensaje
        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
    }
}
