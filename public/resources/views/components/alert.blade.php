@props([
'type' => 'info', // info | success | warning | danger...
'icon' => null, // nombre del icono de Bootstrap Icons (sin "bi-")
'dismissible' => false, // true/false
'message' => null, // texto directo opcional
])

@php
$classes = "alert alert-{$type} shadow-sm rounded mb-3";
if ($dismissible) {
$classes .= " alert-dismissible fade show";
}

// ¿Hay algo que mostrar?
$hasContent = filled($message) || trim($slot) !== '';
@endphp

@if ($hasContent)
<div {{ $attributes->merge(['class' => $classes]) }} role="alert">
    @if ($icon)
    <i class="bi bi-{{ $icon }} me-2"></i>
    @endif

    {{-- Muestra primero el message si existe --}}
    @if (filled($message))
    <span>{{ $message }}</span>
    @endif

    {{-- Y también el slot, si vino contenido entre etiquetas --}}
    {{ $slot }}

    @if ($dismissible)
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    @endif
</div>
@endif
