@extends('layouts.master')

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Auth::user()->email_verified_at === null)
            <div class="alert alert-warning" role="alert">
                {{ __('Antes de continuar, por favor, confirme su correo electrónico que le fue enviado. Si no ha recibido el correo electrónico, haga clic aquí para solicitar otro.') }}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Reenviar correo de verificación') }}</button>.
                </form>
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Mi perfil') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('Identificado correctamente') }}
                    <div>
                        <h4>Información de usuario:</h4>
                        <p>Nombre: {{ $user->name }}</p>
                        <p>Correo: {{ $user->email }}</p>
                        <p>Fecha de registro: {{ $user->created_at }}</p>
                    </div>
                </div>
            </div>

            <h3>Noticias de {{ $user->name }}</h3>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Imagen</th>
                    <th>Título</th>
                    <th>Tema</th>
                    <th>Operaciones</th>
                </tr>
                @foreach($noticias as $noticia)
                <tr>
                    <td class="text-center" style="max-width: 80px">
                        <img class="rounded" style="max-width: 80%" 
                            alt="Imagen de {{ $noticia->titulo }}" 
                            title="Imagen de {{ $noticia->titulo }}" 
                            src="{{ $noticia->imagen ? 
                            asset('storage/images/noticias/'. $noticia->imagen): 
                            asset('storage/images/noticias/default.jpg')}}">
                    </td>
                    <td>{{ $noticia->titulo }}</td>
                    <td>{{ $noticia->tema }}</td>
                    <td class="text-center">
                        <a href="{{ route('noticias.show', $noticia->id) }}">
                            <img height="20" width="20" alt="Ver detalles" title="Ver detalles" src="{{asset('images/buttons/show.svg')}}"></a>
                        <a href="{{ route('noticias.edit', $noticia->id) }}">
                            <img height="20" width="20" alt="Modificar" title="Modificar" src="{{asset('images/buttons/edit.svg')}}"></a>
                        <a href="{{ route('noticias.delete', $noticia->id) }}">
                            <img height="20" width="20" alt="Borrar" title="Borrar" src="{{asset('images/buttons/delete.svg')}}"></a>
                    </td>
                </tr>
                @endforeach
            </table>

            <h3>Comentarios de {{ $user->name }}</h3>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Noticia</th>
                    <th>Comentario</th>
                    <th>Operaciones</th>
                </tr>
                @foreach($comentarios as $comentario)
                <tr>
                    <td><a href="{{ route('noticias.show', $comentario->noticia->id) }}">{{ $comentario->noticia->titulo }}</a></td>
                    <td>{{ $comentario->texto }}</td>
                    <td class="text-center">
                        <a href="#" onclick="event.preventDefault(); if(confirm('¿Seguro que quieres eliminar este comentario?')) { document.getElementById('delete-comentario-{{ $comentario->id }}').submit(); }">
                            <img height="20" width="20" alt="Borrar" title="Borrar" src="{{asset('images/buttons/delete.svg')}}">
                        </a>
                        <form id="delete-comentario-{{ $comentario->id }}" action="{{ route('comentarios.destroy', $comentario->id) }}" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
