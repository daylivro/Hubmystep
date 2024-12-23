<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Withdrawal\WithdrawalRequestCreated;
use App\Notifications\NewWithdrawalRequestAdminNotification;

class NotifyAdminAboutWithdrawalRequest
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
        $user = User::find(1);
        // $user->notify(new NewWithdrawalRequestAdminNotification($event->withdrawalRequest));
    }
}
