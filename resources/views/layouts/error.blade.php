@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show shadow-sm rounded" role="alert">
    <strong>Se han producido errores:</strong>
    <ul class="mb-0 mt-2 ps-3">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif