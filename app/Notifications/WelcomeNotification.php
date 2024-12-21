<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $referalCode)
    {
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
            ->subject('Notification de bienvenue')
            ->greeting('Bonjour Monsieur/Madame')
            ->line('Nous sommes ravis de vous accueillir sur la plateforme Mystep !')
            ->line("Votre inscription a bien été confirmée. Commencez dès maintenant votre marche quotidienne et commencez à accumuler des Miles.")
            ->line("N’hésitez pas à partager votre expérience avec vos amis en utilisant votre code de parrainage {$this->referalCode}. Pour chaque ami qui s'inscrit grâce à vous, vous recevrez 2 Miles supplémentaires.")
            ->line('Si vous n’avez pas effectué cette demande, vous pouvez ignorer ce message.')
            ->salutation('Cordialement');
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
