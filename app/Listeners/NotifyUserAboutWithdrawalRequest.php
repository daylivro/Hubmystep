<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Withdrawal\WithdrawalRequestCreated;
use App\Notifications\WithdrawalRequestCreatedNotification;

class NotifyUserAboutWithdrawalRequest
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
    public function handle(WithdrawalRequestCreated $event): void
    {
        $event->withdrawalRequest->user->notify(new WithdrawalRequestCreatedNotification($event->withdrawalRequest));
    }
}
