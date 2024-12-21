<?php

namespace App\Enums;

use Essa\APIToolKit\Enum\Enum;

class TransactionTypeEnum extends Enum
{
    public const PAYMENT = 'payment';
    public const WITHDRAWAL = 'withdrawal';
}
