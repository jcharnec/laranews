@php($pagina='portada')

@extends('layouts.master')

@section('titulo', 'Portada de Laranews')

@section('login')
@endsection

@section('contenido')
<style>
    .noticia-image {
        width: 100%;
        height: 250px; /* Ajusta esta altura según tus necesidades */
        object-fit: cover; /* Esto asegurará que la imagen se recorte para llenar el contenedor */
    }
</style>

<figure class="row mt-2 mb-2 col-10 offset-1">
    <img class="d-block w-100" alt="Noticia destacada" src="{{ asset('images/noticias/destacada.png') }}">
</figure>

<div class="row mt-2 mb-2 col-10 offset-1">
    <div class="col-12">
        <div class="row">
            @foreach ($noticias as $noticia)
            <div class="card h-100">
                <img class="card-img-top" src="{{ $noticia->imagen ? asset('storage/images/noticias/' . $noticia->imagen) : asset('storage/images/noticias/default.jpg') }}" alt="Imagen de {{ $noticia->titulo }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $noticia->titulo }}</h5>
                    <p class="card-text">{{ Str::limit($noticia->texto, 150, '...') }}</p>
                    <a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-primary">Ver detalles</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@endsection
