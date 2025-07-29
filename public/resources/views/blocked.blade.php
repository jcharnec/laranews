@extends('layouts.master')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card border-danger shadow-sm">
            <div class="row g-0 align-items-center">
                <div class="col-md-4 text-center p-3">
                    <img src="{{ asset('/images/template/blocked.png') }}" alt="Usuario bloqueado"
                        class="img-fluid rounded" style="max-height: 180px;">
                    <p class="text-danger mt-2 mb-0"><strong>Usuario bloqueado</strong></p>
                </div>
                <div class="col-md-8 p-4">
                    <h5 class="card-title text-danger fw-bold">Acceso denegado</h5>
                    <p class="card-text">Has sido <strong>bloqueado</strong> por un administrador.</p>
                    <p class="card-text">
                        Si no estás de acuerdo o quieres conocer los motivos,
                        puedes ponerte en contacto mediante el
                        <a href="{{ route('contacto') }}" class="text-decoration-underline">formulario de contacto</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection