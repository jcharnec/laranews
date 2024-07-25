@extends('layouts.master')

@section('titulo', "Mostrar Noticia: $noticia->titulo")

@section('contenido')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-3">{{ $noticia->titulo }}</h1>
            <p class="text-muted">Tema: {{ $noticia->tema }}</p>
            <p class="text-muted">Autor: {{ $noticia->user ? $noticia->user->name : 'Sin autor' }} | Visitas: {{ $noticia->visitas }} | Fecha de Publicación: {{ $noticia->updated_at ?? $noticia->created_at }} </p>
            <hr>
            <div class="text-center mb-4">
                <img class="rounded img-fluid" alt="Imagen de {{ $noticia->titulo }}" title="Imagen de {{ $noticia->titulo }}" src="{{ $noticia->imagen ? asset('storage/images/noticias/' . $noticia->imagen) : asset('storage/images/noticias/default.jpg') }}">
            </div>
            <p>{{ $noticia->texto }}</p>
            <hr>
            <div class="d-flex justify-content-between mt-4">
                <div>
                    @can('update', $noticia)
                    <a href="{{ route('noticias.edit', $noticia->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modificar
                    </a>
                    @endcan
                    @can('delete', $noticia)
                    <a href="{{ route('noticias.delete', $noticia->id) }}" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Borrar
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->hasRole('lector'))
    <div class="mt-4">
        <h4>Comentarios</h4>
        @foreach($noticia->comentarios as $comentario)
        <div class="card mb-2">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p>{{ $comentario->texto }}</p>
                    <p class="text-muted">{{ $comentario->user->name }} - {{ $comentario->created_at }}</p>
                </div>
                <div>
                    @can('delete', $comentario)
                    <form action="{{ route('comentarios.destroy', $comentario->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <img height="20" width="20" alt="Borrar" title="Borrar" src="{{ asset('images/buttons/delete.svg') }}">
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        @endforeach

        @if(auth()->user()->hasVerifiedEmail())
        <form action="{{ route('comentarios.store', $noticia->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="texto" class="form-control" placeholder="Añadir un comentario" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        @else
        <p class="text-muted">Por favor verifica tu correo electrónico para añadir comentarios.</p>
        @endif
    </div>
    @else
    <p class="text-muted">Inicia sesión como lector para ver y añadir comentarios</p>
    @endif
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-primary m-2">Listado de Noticias</a>
@endsection
