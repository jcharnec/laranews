<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = 'email/verify';

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
            'population' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'birthdate' => ['required', 'date'],
            'imagen' => ['nullable', 'image', 'max:2048'], // <= Nueva validación
        ]);
    }

    protected function create(array $data)
    {
        // Subir imagen si existe
        $imagenPath = null;
        if (request()->hasFile('imagen')) {
            $imagenPath = request()->file('imagen')->store('images/users', 'public');
        }

        // Crear usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'population' => $data['population'],
            'postal_code' => $data['postal_code'],
            'birthdate' => $data['birthdate'],
            'imagen' => $imagenPath ? basename($imagenPath) : null,
        ]);

        // Asignar rol 'user'
        $role = Role::where('role', 'user')->first(); // ojo: tu tabla tiene columna 'role'
        if ($role) {
            try {
                $user->roles()->attach($role->id);
            } catch (QueryException $e) {
                // Opcional: loguear o manejar error
                \Log::error("Error asignando rol a {$user->email}: " . $e->getMessage());
            }
        }

        return $user;
    }
}
