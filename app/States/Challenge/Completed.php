<?php
namespace App\States\Challenge;

class Completed extends ChallengeState
{
    public function label(): string
    {
        return 'completed';
    }

    public function description(): string
    {
        return 'Terminé';
    }

    public function color() : string
    {
        return "success";
    }
}
