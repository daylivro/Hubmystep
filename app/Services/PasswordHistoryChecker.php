<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordHistoryChecker
{
    /**
     * Check if the password is in the user's password history
     */
    public static function check(User $user, string $password): bool
    {
        return $user
            ->passwordHistories()
            ->latest()
            ->take(config('hub.number_of_password_histories'))
            ->get()
            ->contains(function ($passwordHistory) use ($password) {
                return Hash::check($password, $passwordHistory->password);
            });
    }
}
