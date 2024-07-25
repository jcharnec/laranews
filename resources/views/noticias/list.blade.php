@extends('layouts.master')

@section('titulo', 'Listado de Noticias')

@section('contenido')
<form method="GET" class="col-6 row" action="{{ route('noticias.search') }}">

    <input type="text" name="titulo" class="col form-control mr-2 mb-2" placeholder="Título" maxlength="255" value="{{ $titulo ?? '' }}">

    <input name="tema" type="text" class="col form-control mr-2 mb-2" placeholder="Tema" maxlength="255" value="{{ $tema ?? '' }}">

    <button type="submit" class="col btn btn-primary mr-2 mb-2">Buscar</button>
    <a href="{{ route('noticias.index') }}">
        <button type="button" class="col btn btn-secondary mr-2 mb-2">Quitar filtro</button>
    </a>
</form>

<div class="row mt-2 mb-2">
    @foreach ($noticias as $noticia)
    <div class="col-md-4 mb-4">
        <a href="{{ route('noticias.show', $noticia->id) }}" class="card-link">
            <div class="card h-100">
                <img class="card-img-top" src="{{ $noticia->imagen ? asset('storage/images/noticias/' . $noticia->imagen) : asset('storage/images/noticias/default.jpg') }}" alt="Imagen de {{ $noticia->titulo }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $noticia->titulo }}</h5>
                    <p class="card-text">Tema: {{ $noticia->tema }}</p>
                    <p class="card-text d-flex align-items-center">
                        <img src="{{ asset('images/buttons/eye-fill.svg') }}" alt="Visitas" class="mr-2" style="width: 20px; height: 20px; margin-right: 5px;">
                        {{ $noticia->visitas }}
                    </p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
<div class="row">
    <div class="col-12 d-flex justify-content-center">
        {{ $noticias->links() }}
    </div>
</div>
@endsection

<style>
.card-link {
    text-decoration: none;
    color: inherit;
}

.card-link .card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card-link .card:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
