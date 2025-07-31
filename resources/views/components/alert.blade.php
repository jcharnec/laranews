<div class="alert alert-{{ $type }} alert-dismissible fade show shadow-sm rounded mb-3" role="alert">
    @if(isset($icon))
    <i class="bi bi-{{ $icon }} me-2"></i>
    @endif

    <span>{{ $message }}</span>

    {{ $slot }}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
