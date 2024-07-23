@extends('layouts.master')

@section('titulo', "Confirmación de borrado de $noticia->titulo")

@section('contenido')
<!-- Usamos el URL::signedRoute() y no route() para firmar las URL y que no puedan trastear
la ruta haciendo inyecciones, también tenemos un middleware llamado signed para hacer esto -->
<form method="post" class="my-2 border p-5" action="{{ URL::temporarySignedRoute('noticias.destroy', now()->addMinutes(1), $noticia->id) }}">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="DELETE">
    <figure>
        <figcaption>Imagen actual:</figcaption>
        <img class="rounded" style="max-width: 400px" alt="Imagen de {{ $noticia->titulo }}" 
            title="Imagen de {{ $noticia->titulo }}" 
            src="{{ $noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir') . '/' . $noticia->imagen) : asset('storage/' . config('filesystems.noticiasImageDir') . '/default.jpg') }}">
    </figure>
    <label for="confirmdelete">Confirmar el borrado de "{{ $noticia->titulo }}"</label>
    <input type="submit" alt="Borrar" title="Borrar" class="btn btn-danger m-4" value="Borrar" id="confirmdelete">
</form>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-primary m-2">Listado de Noticias</a>
<a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-primary m-2">Regresar a detalles de la noticia</a>
@endsection