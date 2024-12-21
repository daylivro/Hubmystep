<?php
namespace App\States\Challenge;


class Cancelled extends ChallengeState
{

    public function label(): string
    {
        return 'cancelled';
    }

    public function description(): string
    {
        return 'Annulée';
    }

    public function color(): string
    {
        return 'danger';
    }
}
