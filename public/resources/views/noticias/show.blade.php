@extends('layouts.master')

@section('titulo', "Mostrar Noticia: $noticia->titulo")

@section('contenido')
<table class="table table-striped table-bordered">
    <tr>
        <td>ID</td>
        <td>{{$noticia->id}}</td>
    </tr>
    <tr>
        <td>Título</td>
        <td>{{$noticia->titulo}}</td>
    </tr>
    <tr>
        <td>Tema</td>
        <td>{{$noticia->tema}}</td>
    </tr>
    <tr>
        <td>Autor</td>
        <td>{{$noticia->user ? $noticia->user->name : 'Sin autor'}}</td>
    </tr>
    <tr>
        <td>Visitas</td>
        <td>{{$noticia->visitas}}</td>
    </tr>
    <tr>
        <td>Texto</td>
        <td>{{$noticia->texto}}</td>
    </tr>
    @if($noticia->published_at)
    <tr>
        <td>Fecha de Publicación</td>
        <td>{{$noticia->published_at}}</td>
    </tr>
    @endif
    <tr>
        <td>Rechazada</td>
        <td>{{$noticia->rejected ? 'Sí' : 'No'}}</td>
    </tr>
    <tr>
        <td>Imagen</td>
        <td class="text-start">
            <img class="rounded" style="max-width:400px"
                alt="Imagen de {{$noticia->titulo}}"
                title="Imagen de {{$noticia->titulo}}"
                src="{{
                    $noticia->imagen ?
                    asset('storage/images/noticias/' . $noticia->imagen) :
                    asset('storage/images/noticias/default.jpg')
                }}">
        </td>
    </tr>
</table>
<div class="text-end my-3">
    <div class="btn-group mx-2">
        <a class="mx-2" href="{{route('noticias.edit', $noticia->id)}}">
            <img height="40" width="40" alt="Modificar" title="Modificar">
        </a>
        <a class="mx-2" href="{{route('noticias.delete', $noticia->id)}}">
            <img height="40" width="40" alt="Borrar" title="Borrar">
        </a>
    </div>
</div>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('noticias.index')}}" class="btn btn-primary m-2">Listado de Noticias</a>
@endsection
