<?php
namespace App\States\Transaction;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class TransactionState extends State
{
    abstract public function label(): string;
    abstract public function description(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Confirmed::class)
            ->allowTransition(Confirmed::class, Cancelled::class)
            ->allowTransition(Confirmed::class, Completed::class);
    }
}
