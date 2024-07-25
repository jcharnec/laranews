@extends('layouts.master')
@php($pagina='editarNoticia')

@section('titulo', 'Editar Noticia')

@section('contenido')
<form class="my-2 border p-5" method="POST" action="{{ route('noticias.update', $noticia->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group row">
        <label for="inputTitulo" class="col-sm-2 col-form-label">Título</label>
        <input name="titulo" type="text" class="up form-control col-sm-10" id="inputTitulo" placeholder="Título" maxlength="255" value="{{ old('titulo', $noticia->titulo) }}">
    </div>
    <div class="form-group row">
        <label for="inputTema" class="col-sm-2 col-form-label">Tema</label>
        <input name="tema" type="text" class="up form-control col-sm-10" id="inputTema" placeholder="Tema" maxlength="255" value="{{ old('tema', $noticia->tema) }}">
    </div>
    <div class="form-group row">
        <label for="inputTexto" class="col-sm-2 col-form-label">Texto</label>
        <textarea name="texto" class="form-control col-sm-10" id="inputTexto" placeholder="Texto de la noticia" rows="5">{{ old('texto', $noticia->texto) }}</textarea>
    </div>
    <div class="form-group row">
        <label for="inputImagen" class="col-sm-2 col-form-label">Imagen</label>
        <input name="imagen" type="file" class="form-control col-sm-10" id="inputImagen" accept="image/*">
    </div>

    <!-- Vista previa de la imagen actual -->
    @if($noticia->imagen)
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <img src="{{ asset('storage/images/noticias/' . $noticia->imagen) }}" alt="Imagen de {{ $noticia->titulo }}" class="img-fluid mb-2">
        </div>
    </div>
    @endif

    <!-- Checkbox para eliminar la imagen actual -->
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="eliminarimagen" id="eliminarimagen">
                <label class="form-check-label" for="eliminarimagen">
                    Eliminar imagen actual
                </label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="form-group row">
            <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
            <a href="{{ route('noticias.index') }}" class="btn btn-secondary m-2 mt-5">Cancelar</a>
        </div>
    </div>
</form>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-primary m-2">Listado de Noticias</a>
@endsection
