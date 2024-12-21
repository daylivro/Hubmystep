<?php
namespace App\Actions\UserMile;

use App\Models\UserMile;
use Illuminate\Support\Arr;
use App\Models\UserMileMouvment;

class NewMouvmentAction
{
    public function execute(array $data): UserMileMouvment
    {
        $userMile = $this->getUserMile(Arr::get($data, 'user_id'));

        return UserMileMouvment::create([
            'user_mile_id' => $userMile->id,
            'miles' => Arr::get($data, 'miles'),
            'movement' => Arr::get($data, 'movement'),
            'mouvmentable_type' => Arr::get($data, 'mouvmentable_type'),
            'mouvmentable_id' => Arr::get($data, 'mouvmentable_id'),
        ]);
    }

    private function getUserMile($user_id)
    {
        if(UserMile::where('user_id', $user_id)->exists()) {
            return UserMile::where('user_id', $user_id)->first();
        }
        return UserMile::create([
            'user_id' => $user_id,
            'miles' => 0,
        ]);
    }
}
