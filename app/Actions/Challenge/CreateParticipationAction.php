<?php
namespace App\Actions\Challenge;

use App\Models\Challenge;
use Illuminate\Support\Arr;
use App\Models\ChallengeUser;
use Illuminate\Support\Facades\DB;

class CreateParticipationAction
{
    public function execute(array $data): ChallengeUser
    {
        DB::beginTransaction();
        $participation = ChallengeUser::create([
            'challenge_id' => Arr::get($data, 'challenge_id'),
            'user_id' => Arr::get($data, 'user_id'),
            'amount' => Arr::get($data, 'amount'),
            'duration' => Arr::get($data, 'duration'),
            'goal' => Arr::get($data, 'goal'),
        ]);
        DB::commit();

        return $participation;
    }
}
