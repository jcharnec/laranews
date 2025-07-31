@extends('layouts.master')

@section('titulo', 'Registro de usuario')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-8 col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-person-plus-fill me-2"></i> Crear cuenta
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Tu nombre completo">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required
                            placeholder="ejemplo@correo.com">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Población --}}
                    <div class="mb-3">
                        <label for="population" class="form-label">Población</label>
                        <input id="population" type="text"
                            class="form-control @error('population') is-invalid @enderror"
                            name="population" value="{{ old('population') }}" required
                            placeholder="Ciudad o localidad">
                        @error('population')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Código postal --}}
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Código postal</label>
                        <input id="postal_code" type="text"
                            class="form-control @error('postal_code') is-invalid @enderror"
                            name="postal_code" value="{{ old('postal_code') }}" required
                            placeholder="00000">
                        @error('postal_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha de nacimiento --}}
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                        <input id="birthdate" type="date"
                            class="form-control @error('birthdate') is-invalid @enderror"
                            name="birthdate" value="{{ old('birthdate') }}" required>
                        @error('birthdate')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Confirmar contraseña</label>
                        <input id="password-confirm" type="password"
                            class="form-control"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Repite la contraseña">
                    </div>

                    {{-- Foto de perfil --}}
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Foto de perfil (opcional)</label>
                        <input id="imagen" type="file"
                            class="form-control @error('imagen') is-invalid @enderror"
                            name="imagen" accept="image/*">
                        @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Botón --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-orange">
                            <i class="bi bi-person-plus-fill me-1"></i> Registrarse
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">
    <i class="bi bi-card-list"></i> Noticias
</a>
@endsection
