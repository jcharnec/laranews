<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    public function deletedNoticias()
    {
        // Lista solo las borradas (soft delete)
        $noticias = Noticia::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(config('pagination.noticias', 10));

        return view('admin.noticias.deleted', ['noticias' => $noticias]);
    }

    /**
     * Restaura una noticia desde la papelera.
     */
    public function restoreNoticia($id)
    {
        $noticia = Noticia::onlyTrashed()->findOrFail($id);
        $noticia->restore();

        return redirect()->route('admin.deleted.noticias')
            ->with('success', "La noticia '{$noticia->titulo}' ha sido restaurada.");
    }

    /**
     * Elimina definitivamente una noticia (borra el registro).
     * OJO: esta acción no se puede deshacer.
     */
    public function forceDeleteNoticia($id)
    {
        $noticia = Noticia::onlyTrashed()->findOrFail($id);

        if ($noticia->imagen && Storage::disk('public')->exists('images/noticias/' . $noticia->imagen)) {
            Storage::disk('public')->delete('images/noticias/' . $noticia->imagen);
        }

        $noticia->forceDelete();

        return redirect()->route('admin.deleted.noticias')
            ->with('success', "La noticia '{$noticia->titulo}' ha sido eliminada definitivamente.");
    }
    // -----------------------------
    // Gestión de usuarios (tal como ya la tienes)
    // -----------------------------
    public function userList()
    {
        $users = User::orderBy('name', 'ASC')
            ->paginate(config('pagination.users', 10));

        return view('admin.users.list', ['users' => $users]);
    }

    public function userShow(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function userSearch(Request $request)
    {
        $request->validate(['name' => 'max:32', 'email' => 'max:32']);

        $name = $request->input('name', '');
        $email = $request->input('email', '');

        $users = User::orderBy('name', 'ASC')
            ->where('name', 'like', "%$name%")
            ->where('email', 'like', "%$email%")
            ->paginate(config('pagination.users', 10))
            ->appends(['name' => $name, 'email' => $email]);

        return view('admin.users.list', ['users' => $users, 'name' => $name, 'email' => $email]);
    }

    public function setRole(Request $request)
    {
        $role = Role::find($request->input('role_id'));
        $user = User::find($request->input('user_id'));

        try {
            $user->roles()->attach($role->id, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return back()->with('success', "Rol $role->role añadido a $user->name correctamente.");
        } catch (QueryException $e) {
            return back()->withErrors("No se pudo añadir el rol $role->role a $user->name. Es posible que ya lo tenga.");
        }
    }

    public function removeRole(Request $request)
    {
        $role = Role::find($request->input('role_id'));
        $user = User::find($request->input('user_id'));

        try {
            $user->roles()->detach($role->id);
            return back()->with('success', "Rol $role->role quitado a $user->name correctamente.");
        } catch (QueryException $e) {
            return back()->withErrors("No se pudo quitar el rol $role->role a $user->name.");
        }
    }
}
