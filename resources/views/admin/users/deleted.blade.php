@extends('layouts.master')

@section('titulo', 'Usuarios Eliminados')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-danger text-white fw-bold d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-trash3 me-2"></i> Papelera de Usuarios
            </div>
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-light">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            @if($users->isEmpty())
            <div class="alert alert-info">
                No hay usuarios eliminados.
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Eliminado en</th>
                            <th class="text-center">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td>#{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->deleted_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                {{-- Restaurar --}}
                                <form action="{{ route('admin.user.restore', $u->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Restaurar">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>

                                {{-- Eliminar definitivo --}}
                                <form action="{{ route('admin.user.forceDelete', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar definitivamente al usuario? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Borrar definitivo">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection