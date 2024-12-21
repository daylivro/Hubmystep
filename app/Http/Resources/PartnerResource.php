<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'location' => $this->location,
            'phone' => $this->phone,
            'reward_type' => $this->reward?->category->name,
            'reward_value' => $this->reward?->value,
            'qr_code' => $this->qr_code
        ];
    }
}
