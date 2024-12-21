<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

final class ReferalCodeService
{
    public static function generateReferalCode(int $length = 5): string
    {
        do {
            $referalCode = Str::random($length);
        } while (User::where('referal_code', $referalCode)->exists());
        return $referalCode;
    }
}
