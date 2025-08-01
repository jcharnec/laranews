<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirección tras registrarse.
     * Si prefieres forzar verificación de email, puedes usar 'email/verify'.
     */
    protected $redirectTo = 'email/verify';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validador con tus campos (incluye imagen opcional).
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'population'  => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'birthdate'   => ['required', 'date'],
            'imagen'      => ['nullable', 'image', 'max:2048'], // 2 MB
        ]);
    }

    /**
     * MOST IMPORTANT: Sobrescribimos register() para manejar la imagen.
     */
    public function register(Request $request)
    {
        // (Opcional) logs útiles mientras depuramos
        Log::info('[Register] Entré en Auth\\RegisterController@register', [
            'has_file_imagen' => $request->hasFile('imagen'),
            'files'           => array_keys($request->allFiles()),
            'content_type'    => $request->header('Content-Type'),
        ]);

        // 1) Validar
        $this->validator($request->all())->validate();

        // 2) Guardar avatar (si viene)
        $filename = null;
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            Log::info('[Register] Subida recibida', [
                'is_valid'  => $file->isValid(),
                'name'      => $file->getClientOriginalName(),
                'mime'      => $file->getMimeType(),
                'size'      => $file->getSize(),
                'extension' => $file->extension(),
            ]);

            if ($file->isValid()) {
                $filename = Str::uuid() . '.' . $file->extension();
                // storage/app/public/images/users/<uuid>.<ext>
                $file->storeAs('images/users', $filename, 'public');

                Log::info('[Register] Avatar guardado', [
                    'filename'      => $filename,
                    'relative_path' => 'images/users/' . $filename,
                    'disk'          => 'public',
                ]);
            } else {
                Log::warning('[Register] Archivo de avatar no válido');
            }
        }

        // 3) Crear usuario
        $user = User::create([
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'password'    => Hash::make($request->input('password')),
            'population'  => $request->input('population'),
            'postal_code' => $request->input('postal_code'),
            'birthdate'   => $request->input('birthdate'),
            'imagen'      => $filename, // nombre de archivo o null
        ]);

        // 4) Rol por defecto (ajusta 'invitado' o 'lector' a tu preferencia)
        if ($user && ($defaultRole = Role::where('role', 'invitado')->first())) {
            $user->roles()->syncWithoutDetaching([$defaultRole->id]);
        }

        // 5) Evento + login + redirección
        event(new Registered($user));
        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Dejamos create() por compatibilidad;
     * el flujo real usa register() y no pasa archivos aquí.
     */
    protected function create(array $data)
    {
        return User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'population'  => $data['population'] ?? '',
            'postal_code' => $data['postal_code'] ?? '',
            'birthdate'   => $data['birthdate'] ?? null,
            'imagen'      => $data['imagen'] ?? null,
        ]);
    }
}
