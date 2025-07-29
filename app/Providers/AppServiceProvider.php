<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade; // ✅ Esto sí está bien

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::share('autor', 'Joan Pere Charneco');

        // ✅ Registrar directiva personalizada para badge de tema
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
    }
}
