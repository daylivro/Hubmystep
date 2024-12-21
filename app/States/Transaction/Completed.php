<?php
namespace App\States\Transaction;

class Completed extends TransactionState
{
    public function label(): string
    {
        return 'completed';
    }

    public function description(): string
    {
        return 'Effectuée';
    }
}
