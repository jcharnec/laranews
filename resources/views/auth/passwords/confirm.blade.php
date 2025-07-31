@extends('layouts.master')

@section('titulo', 'Confirmar Contraseña')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-shield-lock me-2"></i> Confirmar Contraseña
            </div>

            <div class="card-body">
                <p class="mb-4 text-muted">
                    Por favor confirma tu contraseña antes de continuar.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password"
                            placeholder="Introduce tu contraseña">

                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-outline-orange">
                            <i class="bi bi-check-circle"></i> Confirmar
                        </button>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link text-muted" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('welcome') }}" class="btn btn-outline-orange m-2">Inicio</a>
@endsection
