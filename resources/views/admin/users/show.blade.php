@extends('layouts.master')
@section('titulo', "Detalles del usuario $user->name")

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark fw-bold">
            <i class="bi bi-person-badge me-2"></i> Detalles del usuario
        </div>

        <div class="card-body">
            <div class="row g-4">
                {{-- Columna izquierda: información principal --}}
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="w-25">ID</th>
                                    <td>#{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Correo</th>
                                    <td>
                                        <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                            {{ $user->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha de creación</th>
                                    <td>{{ optional($user->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de verificación</th>
                                    <td>
                                        @php
                                        $verified = $user->email_verified_at ?? $user->verified_at ?? null;
                                        @endphp
                                        {{ $verified ? \Carbon\Carbon::parse($verified)->format('d/m/Y H:i') : 'Sin verificar' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Roles</th>
                                    <td>
                                        @forelse($user->roles as $rol)
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-secondary">{{ $rol->role }}</span>
                                            {{-- Quitar rol --}}
                                            <form method="POST" action="{{ route('admin.user.removeRole') }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="hidden" name="role_id" value="{{ $rol->id }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar rol">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @empty
                                        <span class="text-muted">Sin roles asignados</span>
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <th>Añadir rol</th>
                                    <td>
                                        <form method="POST" action="{{ route('admin.user.setRole') }}" class="row g-2 align-items-center">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <div class="col-md-6">
                                                <select class="form-select" name="role_id">
                                                    @foreach($user->remainingRoles() as $rol)
                                                    <option value="{{ $rol->id }}">{{ $rol->role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-outline-orange">
                                                    <i class="bi bi-plus-circle me-1"></i> Añadir
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Columna derecha: avatar --}}
                <div class="col-lg-4">
                    <div class="d-flex flex-column align-items-center">
                        @if($user->imagen)
                        {{-- Foto real del usuario (160x160, recortada y centrada) --}}
                        <img
                            src="{{ asset('storage/images/users/' . $user->imagen) }}"
                            alt="Avatar de {{ $user->name }}"
                            class="rounded-circle img-thumbnail"
                            style="width:160px;height:160px;object-fit:cover;">
                        @else
                        {{-- Avatar por defecto: mismo tamaño que la foto --}}
                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center"
                            style="width:160px;height:160px;">
                            <i class="bi bi-person" style="font-size:80px;"></i>
                        </div>
                        @endif

                        <div class="text-muted mt-2">{{ $user->name }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('admin.users') }}" class="btn btn-outline-orange m-2">
    <i class="bi bi-arrow-left me-1"></i> Usuarios
</a>
@endsection
