<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordAction
{
    public function execute(User $user, string $password): void
    {
        $user->update([
            'password' => Hash::make($password),
            'last_password_reset_at' => now(),
        ]);
        $user->refresh();
    }
}
