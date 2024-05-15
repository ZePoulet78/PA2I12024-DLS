<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
class SendLoginEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event)
    {
        $user = $event->user;

        // Envoyer un e-mail à l'utilisateur
        Mail::raw('Vous êtes connecté.', function ($message) use ($user) {
            $message->to($user->email)
                    ->from(config('mail.from.address'))
                    ->subject('Connexion réussie');
        });
    }
}
