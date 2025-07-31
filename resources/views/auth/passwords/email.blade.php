@extends('layouts.master')

@section('titulo', 'Restablecer Contraseña')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-envelope-arrow-down me-2"></i> Restablecer Contraseña
            </div>

            <div class="card-body">
                {{-- Mensaje de estado --}}
                @if (session('status'))
                <div class="alert alert-success shadow-sm rounded mb-4" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <p class="mb-4 text-muted">
                    Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="ejemplo@correo.com">

                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Botón --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-orange">
                            <i class="bi bi-send-check"></i> Enviar enlace de restablecimiento
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
