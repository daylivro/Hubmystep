<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
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
        return [
            'miles' => 'required|numeric|min:'.config('hub.min_withdrawal_mile')
        ];
    }

    public function messages(): array
    {
        return [
            'miles.min' => 'Vous ne pouvez que retirer '. config('hub.min_withdrawal_mile') . ' miles ou plus'
        ];
    }
}
