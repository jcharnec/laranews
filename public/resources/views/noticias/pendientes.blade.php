@extends('layouts.master')

@section('titulo', 'Noticias Pendientes')

@section('contenido')
<div class="container mt-4">
    <h1 class="mb-3">Noticias Pendientes</h1>

    @if($noticias->isEmpty())
        <p>No hay noticias pendientes de revisión.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($noticias as $noticia)
                <tr>
                    <td>{{ $noticia->titulo }}</td>
                    <td>{{ $noticia->user ? $noticia->user->name : 'Sin autor' }}</td>
                    <td>{{ $noticia->created_at }}</td>
                    <td>
                        <form action="{{ route('noticias.aprobar', $noticia->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Aprobar</button>
                        </form>
                        <form action="{{ route('noticias.rechazar', $noticia->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
