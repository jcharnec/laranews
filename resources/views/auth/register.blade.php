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
                {{-- Alertas de validación y estado --}}
                @if ($errors->any())
                <x-alert type="danger" icon="exclamation-triangle" :dismissible="false">
                    <strong>Se han producido errores:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
                @endif

                @if (session('status'))
                <x-alert type="success" icon="check-circle">
                    {{ session('status') }}
                </x-alert>
                @endif

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
                            placeholder="ejemplo@correo.com" autocomplete="email">
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
                            placeholder="Ciudad o localidad" autocomplete="address-level2">
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
                            placeholder="00000"
                            inputmode="numeric" pattern="\d{4,10}"
                            title="Introduce entre 4 y 10 dígitos">
                        <div class="form-text">Entre 4 y 10 dígitos.</div>
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
                            name="imagen" accept="image/png,image/jpeg,image/webp,image/gif">
                        <div class="form-text">Formatos: JPG, PNG, WEBP o GIF. Tamaño máx. 2 MB.</div>
                        @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Vista previa --}}
                        <div class="mt-2" id="previewWrapper" style="display:none;">
                            <img id="previewImg" alt="Vista previa" class="rounded border"
                                style="max-width: 120px; height: auto;">
                        </div>
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

{{-- Script de previsualización (no requiere @stack) --}}
<script>
    (function() {
        const input = document.getElementById('imagen');
        const wrapper = document.getElementById('previewWrapper');
        const img = document.getElementById('previewImg');

        if (!input) return;

        input.addEventListener('change', function(e) {
            const file = e.target.files && e.target.files[0];
            if (!file) {
                wrapper.style.display = 'none';
                return;
            }

            const allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (!allowed.includes(file.type)) {
                wrapper.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = (ev) => {
                img.src = ev.target.result;
                wrapper.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    })();
</script>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">
    <i class="bi bi-card-list"></i> Noticias
</a>
@endsection
