@php($pagina = 'portada')

@extends('layouts.master')

@section('titulo', 'Portada de LaraNews')

@section('contenido')

<p class="text-muted">
    Contamos con un total de <strong class="text-dark">{{ $total ?? 0 }}</strong> noticias en nuestro portal.
</p>

<div class="container my-4">
    {{-- Carrusel de destacadas --}}
    @if($destacadas->count() > 0)
    <div id="destacadasCarousel" class="carousel slide mb-5 shadow-sm rounded overflow-hidden" data-bs-ride="carousel">

        {{-- Indicadores --}}
        @if($destacadas->count() > 1)
        <div class="carousel-indicators">
            @foreach($destacadas as $i => $noticia)
            <button type="button"
                data-bs-target="#destacadasCarousel"
                data-bs-slide-to="{{ $i }}"
                class="{{ $i === 0 ? 'active' : '' }}"
                aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                aria-label="Slide {{ $i+1 }}"></button>
            @endforeach
        </div>
        @endif

        {{-- Slides --}}
        <div class="carousel-inner">
            @foreach($destacadas as $i => $noticia)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <img src="{{ $noticia->imagen
                            ? asset('storage/images/noticias/' . $noticia->imagen)
                            : asset('storage/images/noticias/default.jpg') }}"
                    class="d-block w-100"
                    alt="Imagen de {{ $noticia->titulo }}">
                <div class="carousel-caption d-none d-md-block p-4">
                    <h5 class="fw-semibold text-white text-shadow">{{ $noticia->titulo }}</h5>
                    <p class="text-light text-shadow">{{ Str::limit($noticia->texto, 120, '...') }}</p>
                    <a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-orange btn-sm mt-2">
                        <i class="bi bi-eye"></i> Ver más
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Controles --}}
        @if($destacadas->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#destacadasCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#destacadasCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
        @endif
    </div>
    @endif

    {{-- Grid del resto de noticias --}}
    @if($resto->count() > 0)
    <div class="row g-4">
        @foreach($resto as $noticia)
        <div class="col-md-4 d-flex">
            <div class="card shadow-sm flex-fill h-100">
                <img class="card-img-top"
                    src="{{ $noticia->imagen
                            ? asset('storage/images/noticias/' . $noticia->imagen)
                            : asset('storage/images/noticias/default.jpg') }}"
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
                    <a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-outline-orange mt-auto d-grid">
                        <i class="bi bi-eye"></i> Ver detalles
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-info text-center shadow-sm">
        No hay más noticias disponibles en este momento.
    </div>
    @endif
</div>
@endsection