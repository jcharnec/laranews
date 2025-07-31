@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif
