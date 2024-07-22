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
                <div class="col-md-3 mb-4">
                    <figure>
                        <img class="noticia-image" alt="{{ $noticia->titulo }}" src="{{ asset('storage/images/noticias/' . $noticia->imagen) }}">
                        <figcaption>{{ $noticia->titulo }}</figcaption>
                    </figure>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@endsection
