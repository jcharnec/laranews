@extends('layouts.master')

@section('contenido')
<div class="container mt-4">

    {{-- NOTICIA --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-warning text-dark fw-bold fs-5">
            {{ $noticia->titulo }}
        </div>

        <div class="card-body">
            {{-- Imagen --}}
            <div class="text-center mb-4">
                <img class="img-fluid rounded"
                    style="max-height: 350px; object-fit: cover;"
                    alt="Imagen de {{ $noticia->titulo }}"
                    src="{{ $noticia->image_url }}">
            </div>

            {{-- Tema + autor + fecha --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <span class="badge {{ badgeClass($noticia->tema) }}">
                    {{ $noticia->tema }}
                </span>
                <small class="text-muted">
                    Por <strong>{{ $noticia->user->name ?? 'Sin autor' }}</strong> ·
                    {{ $noticia->created_at->format('d/m/Y') }}
                </small>
            </div>

            {{-- Texto --}}
            <p class="fs-6 mb-0">{{ $noticia->texto }}</p>

            {{-- Extra info --}}
            <ul class="list-group list-group-flush mt-4">
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-eye"></i> Visitas</span>
                    <span>{{ $noticia->visitas }}</span>
                </li>
                @if($noticia->published_at)
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-calendar-check"></i> Publicación</span>
                    <span>{{ $noticia->published_at }}</span>
                </li>
                @endif
                <li class="list-group-item d-flex justify-content-between">
                    <span><i class="bi bi-x-circle"></i> Rechazada</span>
                    <span>{{ $noticia->rejected ? 'Sí' : 'No' }}</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- COMENTARIOS --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-semibold">
            Comentarios ({{ $comentarios->total() }})
        </div>

        <div class="card-body">

            {{-- Formulario para comentar --}}
            @auth
            <form method="POST" action="{{ route('noticias.comentarios.store', $noticia) }}" class="mb-4">
                @csrf
                <div class="d-flex">
                    {{-- Avatar usuario logueado --}}
                    @if(auth()->user()->avatar_url)
                    <img src="{{ $user->avatar_url ?? asset('images/default-avatar.png') }}" alt="Avatar">
                    class="rounded-circle me-3" style="width:48px;height:48px;object-fit:cover;">
                    @else
                    <i class="bi bi-person-circle text-secondary me-3" style="font-size:48px;"></i>
                    @endif

                    <div class="flex-grow-1">
                        <label for="texto" class="form-label">Escribe un comentario</label>
                        <textarea id="texto" name="texto" rows="3"
                            class="form-control @error('texto') is-invalid @enderror"
                            placeholder="¿Qué opinas de esta noticia?">{{ old('texto') }}</textarea>
                        @error('texto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="text-end mt-2">
                            <button type="submit" class="btn btn-orange">Publicar</button>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-1"></i>
                <a href="{{ route('login') }}">Inicia sesión</a> para comentar.
            </div>
            @endauth

            {{-- Listado de comentarios paginados --}}
            @forelse($comentarios as $comentario)
            @php
            $u = $comentario->user;
            $cAvatar = $u && $u->imagen
            ? asset('storage/images/users/' . $u->imagen)
            : null;
            $isAuthor = $noticia->user_id === $comentario->user_id;
            @endphp

            <div class="d-flex mb-3 comment-thread">
                {{-- Avatar --}}
                @if($cAvatar)
                <img src="{{ $cAvatar }}" alt="Avatar de {{ $u->name ?? 'Usuario' }}"
                    class="rounded-circle me-3 shadow-sm" style="width:48px;height:48px;object-fit:cover;">
                @else
                <i class="bi bi-person-circle text-secondary me-3" style="font-size:48px;"></i>
                @endif

                {{-- Contenido --}}
                <div class="flex-grow-1">
                    <div class="comment-box p-3 rounded shadow-sm {{ $isAuthor ? 'author-comment' : 'bg-light' }}">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <strong>{{ $u->name ?? 'Usuario' }}</strong>
                                @if($isAuthor)
                                <span class="badge bg-warning text-dark ms-2">Autor</span>
                                @endif
                            </div>
                            <small class="text-muted" title="{{ $comentario->created_at->format('d/m/Y H:i') }}">
                                {{ $comentario->created_at->diffForHumans() }}
                            </small>
                        </div>

                        <p class="mb-2">{{ $comentario->texto }}</p>

                        {{-- Botón eliminar --}}
                        @if(auth()->check() && (auth()->id() === $comentario->user_id || auth()->user()->hasRole('administrador')))
                        <form method="POST" action="{{ route('comentarios.destroy', $comentario->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger mt-1"
                                onclick="return confirm('¿Eliminar este comentario?')">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted mb-0">Sé el primero en comentar esta noticia.</p>
            @endforelse

            {{-- Paginación --}}
            <div class="mt-3 d-flex justify-content-center">
                {{ $comentarios->links() }}
            </div>
        </div>
    </div>

    {{-- Botones con permisos --}}
    <div class="text-end">
        @if(auth()->check() && (auth()->id() === $noticia->user_id || auth()->user()->hasRole('administrador')))
        <a href="{{ route('noticias.edit', $noticia->id) }}" class="btn btn-outline-orange me-2" title="Modificar">
            <i class="bi bi-pencil"></i> Modificar
        </a>
        <a href="{{ route('noticias.delete', $noticia->id) }}" class="btn btn-outline-danger" title="Borrar">
            <i class="bi bi-trash"></i> Borrar
        </a>
        @endif
    </div>

</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">Noticias</a>
@endsection
