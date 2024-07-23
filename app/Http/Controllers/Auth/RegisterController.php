<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->assignRole($user, 'lector');

        return $user;
    }

    protected function assignRole(User $user, string $roleName)
    {
        $role = Role::where('role', $roleName)->first();

        if ($role) {
            try {
                $user->roles()->attach($role->id, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                Log::info("Rol {$role->role} añadido a {$user->name} correctamente.");
            } catch (QueryException $e) {
                Log::error("No se pudo añadir el rol {$role->role} a {$user->name}: {$e->getMessage()}");
                abort(500, "Error al asignar el rol. Inténtelo nuevamente más tarde.");
            }
        } else {
            Log::error("Rol {$roleName} no encontrado.");
            abort(500, "Rol no encontrado. Inténtelo nuevamente más tarde.");
        }
    }
}
