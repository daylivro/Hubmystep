<?php
namespace App\States\Challenge;

use Spatie\ModelStates\State;
use Filament\Support\Colors\Color;
use Spatie\ModelStates\StateConfig;

abstract class ChallengeState extends State
{
    abstract public function label(): string;
    abstract public function description(): string;
    abstract public function color() : string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Cancelled::class)
            ->allowTransition(Pending::class, InProgress::class)
            ->allowTransition(InProgress::class, Cancelled::class)
            ->allowTransition(InProgress::class, Completed::class);
    }
}
