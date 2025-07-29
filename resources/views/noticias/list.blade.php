@extends('layouts.master')

@section('titulo', 'Listado de Noticias')

@section('contenido')
<form method="GET" class="row g-2 align-items-end mb-4" action="{{ route('noticias.search') }}">
    <div class="col-md-4">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" id="titulo" name="titulo" class="form-control"
            placeholder="Título" maxlength="255" value="{{ $titulo ?? '' }}">
    </div>

    <div class="col-md-4">
        <label for="tema" class="form-label">Tema</label>
        <input type="text" id="tema" name="tema" class="form-control"
            placeholder="Tema" maxlength="255" value="{{ $tema ?? '' }}">
    </div>

    <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-orange">Buscar</button>
    </div>

    <div class="col-md-2 d-grid">
        <a href="{{ route('noticias.index') }}" class="btn btn-outline-secondary">Quitar filtro</a>
    </div>
</form>

<div class="row g-4">
    @foreach ($noticias as $noticia)
    <div class="col-md-4 d-flex">
        <div class="card shadow-sm flex-fill h-100">
            <img class="card-img-top" style="height: 220px; object-fit: cover;"
                src="{{ $noticia->image_url }}"
                alt="Imagen de {{ $noticia->titulo }}">

            <div class="card-body d-flex flex-column">
                <span class="badge {{ badgeClass($noticia->tema) }} align-self-start mb-2">
                    {{ $noticia->tema }}
                </span>

                <h5 class="card-title">{{ $noticia->titulo }}</h5>
                <p class="card-text">{{ Str::limit($noticia->texto, 100, '...') }}</p>

                <small class="text-muted mt-2">
                    Por {{ $noticia->user->name ?? 'Anónimo' }} · {{ $noticia->created_at->format('d/m/Y') }}
                </small>

                <a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-outline-orange mt-auto">
                    Ver detalles
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mt-4">
    <div class="col-12 d-flex justify-content-center">
        {{ $noticias->links() }}
    </div>
</div>
@endsection