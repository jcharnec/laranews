@extends('layouts.master')

@section('contenido')
<div class="container mt-4">
    <div class="card border-danger shadow-sm mb-4">
        <div class="card-header bg-danger text-white fw-bold">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Confirmar borrado
        </div>

        <div class="card-body">
            <form method="POST" action="{{ URL::temporarySignedRoute('noticias.destroy', now()->addMinutes(1), $noticia->id) }}">
                @csrf
                @method('DELETE')

                {{-- Imagen --}}
                <div class="mb-3 text-center">
                    <label class="form-label fw-bold d-block mb-2">Imagen actual:</label>
                    <img class="img-fluid rounded"
                        style="max-width: 400px;"
                        alt="Imagen de {{ $noticia->titulo }}"
                        src="{{ $noticia->image_url }}">
                </div>

                {{-- Texto de confirmación --}}
                <p class="mt-3 fs-5 text-center">
                    ¿Estás seguro de que deseas borrar la noticia
                    <strong>"{{ $noticia->titulo }}"</strong>?
                </p>

                {{-- Botón --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-trash"></i> Borrar definitivamente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">
    <i class="bi bi-card-list"></i> Noticias
</a>
<a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-outline-secondary m-2">
    <i class="bi bi-arrow-left"></i> Volver a detalles
</a>
@endsection