<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;

class WalkingRequest extends FormRequest
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
        $currentRoute = $this->route()->getName();
        return match ($currentRoute) {
            'v1.walking.startWalking' => $this->getWalkinRules(),
            'v1.walking.markAsWalked' => $this->getMarkAsWalkedRules(),
            'v1.walking.transfertRewards' => $this->getTransfertRewardsRules(),
            default => [],
        };
    }

    private function getWalkinRules(): array
    {
        return [
            'partner_id' => ['required', 'exists:partners,id'],
            'minimum_steps' => ['required', 'integer', 'min:0'],
            'current_steps_in_beginning' => ['required', 'integer', 'min:0'],
        ];
    }

    public function getTransfertRewardsRules(): array
    {
        return[
            'challenge_id' => ['required', 'exists:at_our_partners,id'],
        ];
    }

    private function getMarkAsWalkedRules(): array
    {
        return [
            'challenge_id' => ['required', 'exists:at_our_partners,id'],
            'current_latitude' => ['required', 'numeric'],
            'current_longitude' => ['required', 'numeric'],
            'current_steps_in_end' => ['required', 'integer', 'min:0'],
        ];
    }
}
