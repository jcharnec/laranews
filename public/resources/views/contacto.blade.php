@extends('layouts.master')
@section('titulo', 'Contactar con LaraNews')

@section('contenido')
<div class="row justify-content-center mt-4">
    <!-- Formulario -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light text-dark fw-semibold">
                Formulario de contacto
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('contacto.email') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Tu email" maxlength="255" required value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="inputNombre" class="form-label">Nombre</label>
                        <input name="nombre" type="text" class="form-control" id="inputNombre" placeholder="Tu nombre" maxlength="255" required value="{{ old('nombre') }}">
                    </div>

                    <div class="mb-3">
                        <label for="inputAsunto" class="form-label">Asunto</label>
                        <input name="asunto" type="text" class="form-control" id="inputAsunto" placeholder="Motivo del mensaje" maxlength="255" required value="{{ old('asunto') }}">
                    </div>

                    <div class="mb-3">
                        <label for="inputMensaje" class="form-label">Mensaje</label>
                        <textarea name="mensaje" class="form-control" id="inputMensaje" rows="4" maxlength="2048" required>{{ old('mensaje') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="inputFichero" class="form-label">Fichero (PDF opcional)</label>
                        <input name="fichero" type="file" class="form-control" accept="application/pdf" id="inputFichero">
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-orange">Enviar</button>
                        <button type="reset" class="btn btn-outline-secondary">Borrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Mapa -->
    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body p-0 h-100">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d47756.809513288754!2d2.0175253!3d41.5735601!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2ses!4v1720001205648!5m2!1ses!2ses"
                    width="100%" height="100%" style="border:0;" allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>


</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('noticias.index') }}" class="btn btn-outline-orange m-2">Noticias</a>
@endsection