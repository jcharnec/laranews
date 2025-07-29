@extends('layouts.master')

@section('titulo', 'Lista de Usuarios')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark fw-bold">
            <i class="bi bi-people me-2"></i> Gestión de Usuarios
        </div>

        <div class="card-body">
            {{-- Formulario de búsqueda --}}
            <form method="GET" action="{{ route('admin.users.search') }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-4">
                    <label for="name" class="form-label">Nombre</label>
                    <input name="name" type="text" id="name"
                        class="form-control"
                        placeholder="Nombre" maxlength="16"
                        value="{{ $name ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="text" id="email"
                        class="form-control"
                        placeholder="Email" maxlength="64"
                        value="{{ $email ?? '' }}">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-orange">Buscar</button>
                </div>
                <div class="col-md-2 d-grid">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">Quitar filtro</a>
                </div>
            </form>

            {{-- Paginación superior --}}
            <div class="d-flex justify-content-end mb-2">
                {{ $users->links() }}
            </div>

            {{-- Tabla de usuarios --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha de Alta</th>
                            <th>Roles</th>
                            <th class="text-center">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                        <tr>
                            <td class="text-center"><strong>#{{ $u->id }}</strong></td>
                            <td>
                                <a href="{{ route('admin.user.show', $u->id) }}" class="text-dark fw-semibold">
                                    {{ $u->name }}
                                </a>
                            </td>
                            <td>
                                <a href="mailto:{{ $u->email }}" class="text-decoration-none">
                                    {{ $u->email }}
                                </a>
                            </td>
                            <td>{{ $u->created_at->format('d/m/Y') }}</td>
                            <td class="small">
                                @foreach ($u->roles as $rol)
                                <span class="badge bg-secondary mb-1">{{ $rol->role }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.user.show', $u->id) }}" class="btn btn-sm btn-outline-orange" title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación inferior --}}
            <div class="d-flex justify-content-end mt-2">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection