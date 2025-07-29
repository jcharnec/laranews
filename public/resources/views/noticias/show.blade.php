@extends('layouts.master')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-warning text-dark fw-bold fs-5">
            {{ $noticia->titulo }}
        </div>

        <div class="card-body">
            {{-- Imagen --}}
            <div class="text-center mb-4">
                <img class="img-fluid rounded"
                    style="max-height: 350px; object-fit: cover;"
                    alt="Imagen de {{ $noticia->titulo }}"
                    src="{{ $noticia->image_url }}">
            </div>

            {{-- Tema + autor + fecha --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <span class="badge {{ badgeClass($noticia->tema) }}">
                    {{ $noticia->tema }}
                </span>
                <small class="text-muted">
                    Por <strong>{{ $noticia->user->name ?? 'Sin autor' }}</strong> ·
                    {{ $noticia->created_at->format('d/m/Y') }}
                </small>
            </div>

            {{-- Texto --}}
            <p class="fs-6">{{ $noticia->texto }}</p>

            {{-- Extra info --}}
            <ul class="list-group list-group-flush mt-4">
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-eye"></i> Visitas</span>
                    <span>{{ $noticia->visitas }}</span>
                </li>
                @if($noticia->published_at)
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-calendar-check"></i> Publicación</span>
                    <span>{{ $noticia->published_at }}</span>
                </li>
                @endif
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-x-circle"></i> Rechazada</span>
                    <span>{{ $noticia->rejected ? 'Sí' : 'No' }}</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Botones con permisos --}}
    <div class="text-end">
        @if(auth()->check() && (auth()->user()->id === $noticia->user_id || auth()->user()->hasRole('administrador')))
        <a href="{{ route('noticias.edit', $noticia->id) }}" class="btn btn-outline-orange me-2" title="Modificar">
            <i class="bi bi-pencil"></i> Modificar
        </a>
        <a href="{{ route('noticias.delete', $noticia->id) }}" class="btn btn-outline-danger" title="Borrar">
            <i class="bi bi-trash"></i> Borrar
        </a>
        @endif
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">Noticias</a>
@endsection