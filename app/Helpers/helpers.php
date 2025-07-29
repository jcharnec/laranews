<?php

if (!function_exists('badgeClass')) {
    function badgeClass($tema)
    {
        $colores = [
            'Deporte' => 'bg-success',
            'Política' => 'bg-danger',
            'Economía' => 'bg-warning text-dark',
            'Cultura' => 'bg-primary',
            'Internacional' => 'bg-dark',
            'Tecnología' => 'bg-info text-dark',
            'Salud' => 'bg-secondary',
        ];

        return $colores[$tema] ?? 'bg-secondary';
    }
}
