<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\WithdrawalRequest;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewWithdrawalRequestAdminNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public WithdrawalRequest $withdrawalRequest)
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
        return (new MailMessage)
                    ->subject("Nouvelle demande de retrait")
                    ->subject("M/Mme {$this->withdrawalRequest->user->first_name} {$this->withdrawalRequest->user->last_name} a fait une demande de retrait")
                    ->line('Le montant de la demande est de ' . $this->withdrawalRequest->amount . ' dh')
                    ->action('Voir la demande', url('/'))
                    ->line('Merci!');
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
