@extends('layouts.master')

@section('titulo', 'Editar Perfil')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-person-lines-fill me-2"></i> Editar Perfil
            </div>

            <div class="card-body">

                {{-- Mensaje de éxito --}}
                @if (session('status'))
                <div class="alert alert-success shadow-sm rounded" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                {{-- Errores de validación --}}
                @if ($errors->any())
                <div class="alert alert-danger shadow-sm rounded">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Formulario --}}
                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    {{-- Población --}}
                    <div class="mb-3">
                        <label for="population" class="form-label">Población</label>
                        <input type="text" name="population" class="form-control" value="{{ old('population', $user->population) }}">
                    </div>

                    {{-- Código postal --}}
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Código Postal</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code) }}">
                    </div>

                    {{-- Fecha de nacimiento --}}
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                        <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate) }}">
                    </div>

                    {{-- Avatar actual --}}
                    @if ($user->imagen)
                    <div class="mb-3">
                        <label class="form-label">Avatar actual</label><br>
                        <img src="{{ asset('storage/images/users/' . $user->imagen) }}" alt="Avatar" class="img-thumbnail" width="120">
                    </div>
                    @endif

                    {{-- Nueva imagen --}}
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Cambiar Avatar</label>
                        <input type="file" name="imagen" class="form-control">
                        <small class="text-muted">Máximo 2 MB. Solo imágenes.</small>
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    {{-- Confirmación --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    {{-- Botón --}}
                    <button type="submit" class="btn btn-outline-orange">
                        <i class="bi bi-save me-1"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>

        {{-- Eliminar cuenta --}}
        <div class="card border-danger mt-5">
            <div class="card-header bg-danger text-white fw-bold d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Eliminar Cuenta
            </div>

            <div class="card-body">
                <p class="text-danger mb-3">
                    Esta acción eliminará tu cuenta de forma <strong>permanente</strong>. No podrás recuperarla después.
                </p>

                <form method="POST" action="{{ route('user.destroy') }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción es irreversible.');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i> Confirmar eliminación
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection