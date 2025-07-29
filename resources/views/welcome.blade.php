@php($pagina = 'portada')

@extends('layouts.master')

@section('titulo', 'Portada de LaraNews')

@section('contenido')
<div class="container my-4">
    {{-- Noticia destacada --}}
    @if($noticias->count() > 0)
    @php($destacada = $noticias->first())
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6">
                        <img class="w-100 h-100"
                            style="object-fit: cover; min-height: 300px"
                            src="{{ $destacada->imagen
                                        ? asset('storage/images/noticias/' . $destacada->imagen)
                                        : asset('storage/images/noticias/default.jpg') }}"
                            alt="Imagen destacada de {{ $destacada->titulo }}">
                    </div>
                    <div class="col-md-6 d-flex flex-column justify-content-center p-4">
                        <span class="badge {{ badgeClass($destacada->tema) }} mb-2">
                            {{ $destacada->tema }}
                        </span>
                        <h3 class="fw-bold">{{ $destacada->titulo }}</h3>
                        <p class="text-muted">{{ Str::limit($destacada->texto, 160, '...') }}</p>
                        <small class="text-secondary mb-3">
                            Por {{ $destacada->user->name ?? 'Anónimo' }} · {{ $destacada->created_at->format('d/m/Y') }}
                        </small>
                        <a href="{{ route('noticias.show', $destacada->id) }}" class="btn btn-orange align-self-start">
                            <i class="bi bi-arrow-right-circle"></i> Leer más
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Listado de noticias --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h4 class="fw-bold mb-4">Últimas Noticias</h4>
            <div class="row g-4">
                @foreach ($noticias->skip(1) as $noticia)
                <div class="col-md-4 d-flex">
                    <div class="card shadow-sm flex-fill h-100 border-0">
                        <img class="card-img-top"
                            style="height: 200px; object-fit: cover;"
                            src="{{ $noticia->imagen
                                        ? asset('storage/images/noticias/' . $noticia->imagen)
                                        : asset('storage/images/noticias/default.jpg') }}"
                            alt="Imagen de {{ $noticia->titulo }}">

                        <div class="card-body d-flex flex-column">
                            <span class="badge {{ badgeClass($noticia->tema) }} align-self-start mb-2">
                                {{ $noticia->tema }}
                            </span>
                            <h5 class="card-title fw-semibold">{{ $noticia->titulo }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($noticia->texto, 80, '...') }}</p>
                            <small class="text-secondary mb-3">
                                Por {{ $noticia->user->name ?? 'Anónimo' }} · {{ $noticia->created_at->format('d/m/Y') }}
                            </small>
                            <a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-outline-orange mt-auto">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Si no hay más noticias --}}
                @if($noticias->count() <= 1)
                    <div class="text-center mt-4">
                    <p class="text-muted">No hay más noticias por el momento.</p>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection