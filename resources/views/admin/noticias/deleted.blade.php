@extends('layouts.master')

@section('titulo', 'Noticias eliminadas')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-danger text-white fw-bold">
            <i class="bi bi-trash3-fill me-2"></i> Noticias eliminadas
        </div>

        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success shadow-sm rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if($noticias->count() === 0)
            <p class="text-muted mb-0">No hay noticias en la papelera.</p>
            @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Título</th>
                            <th>Tema</th>
                            <th>Autor</th>
                            <th>Fecha de borrado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($noticias as $noticia)
                        <tr>
                            <td style="width: 100px;">
                                <img src="{{ $noticia->image_url }}"
                                    class="img-fluid rounded"
                                    style="max-height: 60px; object-fit: cover;">
                            </td>
                            <td><strong>{{ $noticia->titulo }}</strong></td>
                            <td>
                                <span class="badge {{ badgeClass($noticia->tema) }}">
                                    {{ $noticia->tema }}
                                </span>
                            </td>
                            <td>{{ $noticia->user->name ?? 'Anónimo' }}</td>
                            <td>{{ $noticia->deleted_at?->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                {{-- Restaurar --}}
                                <form action="{{ route('admin.noticias.restore', $noticia->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-success" title="Restaurar">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>

                                {{-- Eliminar definitivamente --}}
                                <form action="{{ route('admin.noticias.forceDelete', $noticia->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar definitivamente esta noticia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Eliminar definitivamente">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $noticias->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">
    <i class="bi bi-card-list"></i> Noticias
</a>
@endsection
