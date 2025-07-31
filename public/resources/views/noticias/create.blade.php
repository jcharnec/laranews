@extends('layouts.master')
@php($pagina = 'nuevanoticia')

@section('titulo', 'Crear Nueva Noticia')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark fw-bold">
            <i class="bi bi-plus-circle me-2"></i> Crear Nueva Noticia
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('noticias.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Título --}}
                <div class="mb-3">
                    <label for="inputTitulo" class="form-label">Título</label>
                    <input name="titulo" type="text"
                        class="form-control @error('titulo') is-invalid @enderror"
                        id="inputTitulo" placeholder="Título"
                        maxlength="255" value="{{ old('titulo') }}">
                    @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tema --}}
                <div class="mb-3">
                    <label for="inputTema" class="form-label">Tema</label>
                    <select name="tema" id="inputTema"
                        class="form-select @error('tema') is-invalid @enderror">
                        <option value="">Selecciona un tema...</option>
                        @foreach ($temas as $tema)
                        <option value="{{ $tema }}" {{ old('tema') == $tema ? 'selected' : '' }}>
                            {{ $tema }}
                        </option>
                        @endforeach
                    </select>
                    @error('tema')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Texto --}}
                <div class="mb-3">
                    <label for="inputTexto" class="form-label">Texto</label>
                    <textarea name="texto"
                        class="form-control @error('texto') is-invalid @enderror"
                        id="inputTexto" placeholder="Texto de la noticia"
                        rows="5">{{ old('texto') }}</textarea>
                    @error('texto')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Imagen --}}
                <div class="mb-4">
                    <label for="inputImagen" class="form-label">Imagen</label>
                    <input name="imagen" type="file"
                        class="form-control @error('imagen') is-invalid @enderror"
                        id="inputImagen" accept="image/*">
                    @error('imagen')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Borrar
                    </button>
                    <button type="submit" class="btn btn-outline-orange">
                        <i class="bi bi-check2-circle"></i> Guardar
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
@endsection
