<?php
namespace App\States\Challenge;

class InProgress extends ChallengeState
{
    public function label(): string
    {
        return 'in_progress';
    }

    public function description(): string
    {
        return 'En cours';
    }

    public function color() : string
    {
        return "info";
    }
}
