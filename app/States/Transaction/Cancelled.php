<?php
namespace App\States\Transaction;

class Cancelled extends TransactionState
{
    public function label() : string
    {
        return 'cancelled';
    }

    public function description() : string
    {
        return 'Annulée';
    }
}
