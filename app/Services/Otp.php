<?php
namespace App\Services;

class Otp
{
    /**
     * Generate a random OTP
     * @param int $length
     * @param string $key
     * @return string
     */
    public static function generate(string $key)
    {
        return (new \Ichtrojan\Otp\Otp())->generate($key, 'numeric', 6, 5);
    }

    /**
     * Verify an OTP
     * @param string $otp
     * @param string $key
     * @return bool
     */
    public static function verify(string $key, string $otp): bool
    {
        return (new \Ichtrojan\Otp\Otp())->validate($key, $otp)->status;
    }
}
