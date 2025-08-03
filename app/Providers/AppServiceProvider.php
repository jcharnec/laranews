<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Paginator::useBootstrap();
        View::share('autor', 'Joan Pere Charneco');

        // Directiva para los colores de badge según tema
        Blade::directive('badgeClass', function ($tema) {
            return "<?php echo match(strtolower($tema)) {
                'política' => 'bg-danger',
                'deportes' => 'bg-success',
                'cultura' => 'bg-primary',
                'economía' => 'bg-warning text-dark',
                'tecnología' => 'bg-info text-dark',
                'internacional' => 'bg-dark',
                'sociedad' => 'bg-secondary',
                'opinión' => 'bg-light text-dark',
                default => 'bg-secondary',
            }; ?>";
        });

        // ✅ Solución al problema del CSS no cargado en producción
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
