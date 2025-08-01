<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PerfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'population'  => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'birthdate'   => 'nullable|date',
            'password'    => 'nullable|string|min:8|confirmed',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($user->imagen) {
                Storage::disk('public')->delete('images/users/' . $user->imagen);
            }
            $filename = Str::uuid() . '.' . $request->imagen->extension();
            $request->imagen->storeAs('images/users', $filename, 'public');
            $user->imagen = $filename;
        }

        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->population  = $request->population;
        $user->postal_code = $request->postal_code;
        $user->birthdate   = $request->birthdate;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('perfil.edit')->with('status', 'Perfil actualizado correctamente.');
    }
}
