<?php

namespace App\Http\Requests\User;

use App\Services\PasswordHistoryChecker;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeName = $this->route()->getName();
        $routeBase = config('hub.api_version') . '.auth';
        $routeBase = explode('/', $routeBase)[2];
        return match ($routeName) {
            $routeBase . '.login' => $this->getLoginRules(),
            $routeBase . '.register' => $this->getRegisterRules(),
            $routeBase . '.password.forgot' => $this->getPasswordForgotRules(),
            $routeBase . '.password.reset' => $this->getPasswordResetRules(),
            $routeBase . '.otp.resend' => $this->getResentOtpRules(),
            $routeBase . '.otp.verify' => $this->getVerifyOtpRules(),
            default => [],
        };
    }

    /**
     * Get the validation rules for register request.
     */
    private function getLoginRules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Get the validation rules for register request.
     */
    private function getRegisterRules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'address' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'array'],
            'referal_code' => ['nullable', 'string']
        ];
    }

    /**
     * Get the validation rules for password forgot request.
     */
    private function getPasswordForgotRules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }

    /**
     * Get the validation rules for password reset request.
     */
    private function getPasswordResetRules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:email',
                function ($attribute, $value, $fail) {
                    $user = \App\Models\User::where('email', $this->email)->first();
                    if ($user && PasswordHistoryChecker::check($user, $value)) {
                        $fail(__('Password has been used before'));
                    }
                },
            ],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ];
    }

    /**
     * Get the validation rules for resent OTP request.
     */
    private function getResentOtpRules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }

    /**
     * Get the validation rules for verify OTP request.
     */
    private function getVerifyOtpRules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'token' => ['required', 'string'],
        ];
    }
}
