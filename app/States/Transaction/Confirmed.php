<?php
namespace App\States\Transaction;

class Confirmed extends TransactionState
{
    public function label(): string
    {
        return 'confirmed';
    }

    public function description(): string
    {
        return 'En attente de paiement';
    }
}
