@extends('layouts.master')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light text-dark fw-semibold">
                Iniciar sesión
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}"
                            required autocomplete="email" autofocus>

                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Recordar -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Recuérdame
                        </label>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="submit" class="btn btn-orange">
                            Entrar
                        </button>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            ¿Has olvidado tu contraseña?
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
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">Noticias</a>
@endsection