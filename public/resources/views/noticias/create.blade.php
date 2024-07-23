@extends('layouts.master')
@php($pagina='nuevanoticia')

@section('titulo', 'Nueva Noticia')

@section('contenido')
<form class="my-2 border p-5" method="POST" action="{{ route('noticias.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
        <label for="inputTitulo" class="col-sm-2 col-form-label">Título</label>
        <input name="titulo" type="text" class="up form-control col-sm-10" id="inputTitulo" placeholder="Título" maxlength="255" value="{{ old('titulo') }}">
    </div>
    <div class="form-group row">
        <label for="inputTema" class="col-sm-2 col-form-label">Tema</label>
        <input name="tema" type="text" class="up form-control col-sm-10" id="inputTema" placeholder="Tema" maxlength="255" value="{{ old('tema') }}">
    </div>
    <div class="form-group row">
        <label for="inputTexto" class="col-sm-2 col-form-label">Texto</label>
        <textarea name="texto" class="form-control col-sm-10" id="inputTexto" placeholder="Texto de la noticia" rows="5">{{ old('texto') }}</textarea>
    </div>
    <div class="form-group row">
        <label for="inputImagen" class="col-sm-2 col-form-label">Imagen</label>
        <input name="imagen" type="file" class="form-control col-sm-10" id="inputImagen" accept="image/*">
    </div>
    <div class="d-flex justify-content-center">
        <div class="form-group row">
            <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
            <button type="reset" class="btn btn-secondary m-2">Borrar</button>
        </div>
    </div>
</form>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-primary m-2">Listado de Noticias</a>
@endsection
