<?php

namespace App\Console\Commands;

use App\Models\ChallengeUser;
use Illuminate\Console\Command;
use App\States\Challenge\Completed;
use App\States\Challenge\InProgress;

class CheckChallengeState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenge:completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update challenge state if needed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $challengeInProgress = ChallengeUser::getAll();
        $challengeInProgress->each(function ($challenge) {
            $endAt = $challenge->start_at->addDays($challenge->challenge->duration);
            if ($endAt->isPast() || $challenge->currentParts($challenge->user) >= $challenge->challenge->number_of_parts) {
                $challenge->state->transitionTo(Completed::class);
            }
        });
    }
}
