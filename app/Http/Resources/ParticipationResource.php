<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'state_code' => $this->state->label(),
            'state_description' => $this->state->description(),
            'subscription_amount' => $this->amount . ' diram',
            'duration' => $this->duration . ' jours',
            'remaining_duration' => $this->remainingDays() . ' jours',
            'current_parts' => $this->currentParts(auth()->user()) . ' parts',
            'remaining_parts' => $this->remainingParts(auth()->user()) . ' parts',
            'challenge' => new ChallengeResource($this->whenLoaded('challenge')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
