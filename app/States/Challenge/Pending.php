<?php
namespace App\States\Challenge;

class Pending extends ChallengeState
{
    public function label(): string
    {
        return 'pending';
    }

    public function description(): string
    {
        return 'En attente de validation';
    }

    public function color() : string
    {
        return 'secondary';
    }
}
