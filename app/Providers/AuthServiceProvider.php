<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\NoticiaPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

                // traduccion del email de validacion
                VerifyEmail::toMailUsing(function ($notificable, $url) {
                    return (new MailMessage)
                        ->subject('Verificacion de cuenta')
                        ->line('Haga click en el siguiente enlace para verificar su cuenta')
                        ->action('Verificar cuenta', $url)
                        ->greeting('Hola')
                        ->salutation('Un saludo')
                        ->action('Verificar email', $url);
                });
    }
}
