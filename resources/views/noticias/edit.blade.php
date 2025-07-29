@extends('layouts.master')

@section('titulo', "Modificar Noticia: $noticia->titulo")

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                Editar Noticia
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('noticias.update', $noticia->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" id="titulo"
                            class="form-control @error('titulo') is-invalid @enderror"
                            value="{{ old('titulo', $noticia->titulo) }}" required maxlength="255">
                        @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tema (selector) --}}
                    <div class="mb-3">
                        <label for="tema" class="form-label">Tema</label>
                        <select name="tema" id="tema" class="form-select @error('tema') is-invalid @enderror" required>
                            @foreach(($temas ?? ['Actualidad','Política','Deportes','Cultura','Tecnología','Economía','Opinión']) as $t)
                            <option value="{{ $t }}" {{ old('tema', $noticia->tema) === $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                            @endforeach
                        </select>
                        @error('tema')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Texto --}}
                    <div class="mb-3">
                        <label for="texto" class="form-label">Texto</label>
                        <textarea name="texto" id="texto" rows="6"
                            class="form-control @error('texto') is-invalid @enderror"
                            required>{{ old('texto', $noticia->texto) }}</textarea>
                        @error('texto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Imagen --}}
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Cambiar imagen</label>
                        <input class="form-control @error('imagen') is-invalid @enderror" type="file" id="imagen" name="imagen" accept="image/*">
                        @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Vista previa de la imagen actual --}}
                        <div class="mt-3">
                            <img
                                src="{{ $noticia->imagen
                                        ? asset('storage/' . $noticia->imagen)
                                        : asset('storage/images/noticias/default.jpg') }}"
                                alt="Imagen actual"
                                class="img-thumbnail"
                                style="max-width: 220px;">
                            <p class="mt-2 text-muted small">Imagen actual</p>
                        </div>
                    </div>

                    {{-- Botón --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-outline-orange">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">Noticias</a>
<a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-outline-secondary m-2">Volver a detalles</a>
@endsection