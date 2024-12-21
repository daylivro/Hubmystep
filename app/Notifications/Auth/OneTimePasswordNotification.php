<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OneTimePasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $code)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Notification de code OTP'))
            ->line(__('Veuillez trouver ci-dessous le code OTP pour votre compte'))
            ->line(__('Votre code OTP: ' . $this->code))
            ->line(__('Ce code OTP expire dans 5 minutes.'))
            ->line(__("Si vous êtes l'auteur de cette demande, veuillez renseigner le code sur l'écran de connexion. Si ce n'est pas le cas, veuillez changer immédiatement votre mot de passe."));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
                //
            ];
    }
}
