@extends('layouts.master')

@section('titulo', 'Mi Panel de Usuario')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-speedometer2 me-2"></i> Panel de Usuario
            </div>

            <div class="card-body">
                {{-- Mensaje de estado --}}
                @if (session('status'))
                <div class="alert alert-success shadow-sm rounded mb-4" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                {{-- Bienvenida --}}
                <p class="fs-5 mb-2">
                    ¡Hola <strong>{{ Auth::user()->name }}</strong>!
                </p>
                <p class="text-muted">
                    Has iniciado sesión correctamente. Desde aquí puedes gestionar tus noticias y tu perfil.
                </p>

                {{-- Botones de acción --}}
                <div class="d-flex flex-wrap mt-4 mb-4">
                    <a href="{{ route('noticias.index') }}" class="btn btn-outline-orange me-2 mb-2">
                        <i class="bi bi-card-list me-1"></i> Ver Todas las Noticias
                    </a>
                    <a href="{{ route('noticias.create') }}" class="btn btn-success mb-2">
                        <i class="bi bi-plus-circle me-1"></i> Nueva Noticia
                    </a>
                </div>

                {{-- Listado de noticias del usuario --}}
                @if(isset($noticias) && $noticias->count())
                <h5 class="fw-bold mb-3">Tus Noticias</h5>
                <ul class="list-group">
                    @foreach($noticias as $noticia)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $noticia->titulo }}</strong>
                            <span class="badge {{ badgeClass($noticia->tema) }} ms-2">{{ $noticia->tema }}</span>
                        </div>
                        <a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-sm btn-outline-orange">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                    </li>
                    @endforeach
                </ul>

                {{-- Paginación --}}
                <div class="mt-3">
                    {{ $noticias->links() }}
                </div>
                @else
                <p class="text-muted mt-4">Todavía no has creado ninguna noticia.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
