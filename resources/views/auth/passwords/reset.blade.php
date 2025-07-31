@extends('layouts.master')

@section('titulo', 'Crear nueva contraseña')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-shield-lock me-2"></i> Crear nueva contraseña
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $email ?? old('email') }}"
                            required autocomplete="email" autofocus
                            placeholder="ejemplo@correo.com">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nueva contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva contraseña</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Usa al menos 8 caracteres. Combina letras y números si es posible.</div>
                    </div>

                    {{-- Confirmación --}}
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Confirmar contraseña</label>
                        <input id="password-confirm" type="password"
                            class="form-control" name="password_confirmation"
                            required autocomplete="new-password"
                            placeholder="Repite la nueva contraseña">
                    </div>

                    {{-- Botón --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-orange">
                            <i class="bi bi-check2-circle me-1"></i> Restablecer contraseña
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
<a href="{{ route('login') }}" class="btn btn-outline-secondary m-2">
    <i class="bi bi-box-arrow-in-left"></i> Iniciar sesión
</a>
@endsection
