@extends('layouts.master')

@section('titulo', 'Verificación de correo')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-bold">
                Verifica tu dirección de correo electrónico
            </div>

            <div class="card-body">
                @if (session('resent'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
                    Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                @endif

                <p>Antes de continuar, por favor revisa tu correo y haz clic en el enlace de verificación que te hemos enviado.</p>

                <p>¿No has recibido el correo?</p>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        Reenviar enlace de verificación
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection