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

        $deletedCount = User::onlyTrashed()->count(); // ← aquí está el contador

        return view('admin.users.list', [
            'users' => $users,
            'deletedCount' => $deletedCount,
        ]);
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

    /**
     * Elimina un usuario de forma definitiva.
     */
    public function userDestroy(User $user)
    {
        // Previene que un admin se borre a sí mismo
        if (auth()->id() === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Previene eliminar al admin principal (ID 1)
        if ($user->id === 1) {
            return back()->with('error', 'No puedes eliminar al administrador principal.');
        }

        // Si el usuario es administrador, verificar si es el único
        $adminRole = Role::where('role', 'administrador')->first();
        $adminCount = $adminRole ? $adminRole->users()->count() : 0;

        if ($user->roles->contains($adminRole) && $adminCount <= 1) {
            return back()->with('error', 'No puedes eliminar al único administrador del sistema.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Lista de usuarios eliminados (soft deleted)
     */
    public function deletedUsers()
    {
        $users = User::onlyTrashed()->orderByDesc('deleted_at')->paginate(10);
        return view('admin.users.deleted', compact('users'));
    }

    /**
     * Restaurar usuario eliminado
     */
    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.deleted.users')
            ->with('success', "El usuario '{$user->name}' ha sido restaurado.");
    }

    /**
     * Eliminar definitivamente un usuario
     */
    public function forceDeleteUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        // Elimina su imagen si existe
        if ($user->imagen && Storage::disk('public')->exists('images/users/' . $user->imagen)) {
            Storage::disk('public')->delete('images/users/' . $user->imagen);
        }

        $user->forceDelete();

        return redirect()->route('admin.deleted.users')
            ->with('success', "El usuario '{$user->name}' ha sido eliminado permanentemente.");
    }
}
