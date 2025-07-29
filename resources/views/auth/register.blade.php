@extends('layouts.master')

@section('titulo', 'Registro de usuario')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-8 col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light text-dark fw-semibold">
                Crear cuenta
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Población -->
                    <div class="mb-3">
                        <label for="population" class="form-label">Población</label>
                        <input id="population" type="text"
                            class="form-control @error('population') is-invalid @enderror"
                            name="population" value="{{ old('population') }}" required>
                        @error('population')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Código postal -->
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Código postal</label>
                        <input id="postal_code" type="text"
                            class="form-control @error('postal_code') is-invalid @enderror"
                            name="postal_code" value="{{ old('postal_code') }}" required>
                        @error('postal_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fecha de nacimiento -->
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                        <input id="birthdate" type="date"
                            class="form-control @error('birthdate') is-invalid @enderror"
                            name="birthdate" value="{{ old('birthdate') }}" required>
                        @error('birthdate')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Confirmar contraseña</label>
                        <input id="password-confirm" type="password"
                            class="form-control"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <!-- Botón -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-orange">
                            Registrarse
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
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">Noticias</a>
@endsection