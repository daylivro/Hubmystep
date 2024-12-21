<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserMile;

class UserObserver
{
    public function created(User $user): void
    {
        UserMile::create([
            'user_id' => $user->id,
            'miles' => 0,
        ]);
    }
    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->isDirty('password')) {
            $this->logPasswordHistory($user);
        }
    }

    private function logPasswordHistory(User $user): void
    {
        $user->passwordHistories()->create([
            'password' => $user->password, // Password already hashed & saved so just take from model
        ]);
    }
}
