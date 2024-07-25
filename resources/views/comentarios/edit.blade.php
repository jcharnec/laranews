@extends('layouts.master')

@section('titulo', "Editar Comentario")

@section('contenido')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Comentario</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comentarios.update', $comentario->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <textarea name="texto" class="form-control" rows="5" required>{{ old('texto', $comentario->texto) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Guardar</button>
                        <a href="{{ route('noticias.show', $comentario->noticia_id) }}" class="btn btn-secondary mt-3">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
