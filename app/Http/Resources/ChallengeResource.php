<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => asset('storage/' . $this->image),
            'subscription_amount' => $this->amount . ' diram',
            'duration' => $this->duration . ' jours',
            'number_of_parts' => $this->number_of_parts . ' parts',
            'reward' => RewardResource::collection($this->whenLoaded('rewards')),
        ];
    }
}