<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserMile;
use App\Models\DailyShare;
use App\Actions\UserMile\NewMouvmentAction;

class DailyShareService
{

    public NewMouvmentAction $newMouvment;
    public function __construct()
    {
        $this->newMouvment = new NewMouvmentAction();
    }
    public function getMiles(int $shares): int
    {
        // switch ($shares) {
        //     case $shares > 1500 && $shares < 3000:
        //         return 1;
        //     case $shares > 3000 && $shares < 6500:
        //         return 3;
        //     case $shares > 6500 && $shares < 100000:
        //         return 6;
        //     case $shares > 10000 && $shares < 15000:
        //         return 10;
        //     case $shares > 15000 && $shares < 20000:
        //         return 15;
        //     case $shares > 20000:
        //         return 25;
        //     default:
        //         return 0;
        switch ($shares) {
            case $shares > 15 && $shares < 30:
                return 1;
            case $shares > 30 && $shares < 65:
                return 3;
            case $shares > 65 && $shares < 100:
                return 6;
            case $shares > 100 && $shares < 150:
                return 10;
            case $shares > 150 && $shares < 200:
                return 15;
            case $shares > 200:
                return 25;
            default:
                return 0;
        }
    }


    public function save(DailyShare $dailyShare): void
    {
        $miles = $this->getMiles($dailyShare->shares);

        if ($miles == 0) {
            return;
        }

        $userMile = UserMile::where('user_id', $dailyShare->user_id)->first();

        if (!$userMile) {
            $userMile = UserMile::create([
                'user_id' => $dailyShare->user_id,
                'miles' => 0,
            ]);
        }

        UserMile::where('user_id', $dailyShare->user_id)->update([
            'miles' => $userMile->miles + $miles
        ]);

        $this->newMouvment->execute([
            'user_id' => $dailyShare->user_id,
            'miles' => $miles,
            'movement' => 'in',
            'mouvmentable_type' => 'App\Models\DailyShare',
            'mouvmentable_id' => $dailyShare->id,
        ]);
    }
}
