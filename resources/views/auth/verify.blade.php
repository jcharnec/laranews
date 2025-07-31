@extends('layouts.master')

@section('titulo', 'Verificación de correo')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-envelope-check-fill me-2"></i> Verifica tu dirección de correo electrónico
            </div>

            <div class="card-body">
                @if (session('resent'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Se ha enviado un nuevo enlace de verificación a tu correo.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                @endif

                <p class="mb-3">
                    Antes de continuar, revisa tu bandeja de entrada y haz clic en el enlace de verificación que te hemos enviado.
                </p>

                <p class="mb-3">¿No has recibido el correo?</p>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-orange">
                        <i class="bi bi-arrow-repeat me-1"></i> Reenviar enlace de verificación
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{ route('welcome') }}" class="btn btn-outline-secondary m-2">
    <i class="bi bi-house-door"></i> Inicio
</a>
@endsection
