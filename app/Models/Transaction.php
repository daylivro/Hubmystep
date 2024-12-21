<?php

namespace App\Models;

use Spatie\ModelStates\HasStates;
use Illuminate\Database\Eloquent\Model;
use App\States\Transaction\TransactionState;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, HasStates;


    protected $gaurded = ['id'];


    protected $casts = [
        'state' => TransactionState::class
    ];

    public function transactionable()
    {
        return $this->morphTo();
    }
}
