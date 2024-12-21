<?php
namespace App\Actions\Challenge;

use App\Models\Challenge;
use App\Models\ChallengeUser;
use App\States\Challenge\InProgress;

class MarkChallengeAsPaidAction
{
    public function execute(ChallengeUser $challengeUser): ChallengeUser
    {
        $challengeUser->update([
            'start_at' => now(),
            'payment_completed_at' => now(),
        ]);
        $challengeUser->state->transitionTo(InProgress::class);
        return $challengeUser->fresh();
    }
}
