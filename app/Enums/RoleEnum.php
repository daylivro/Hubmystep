<?php

namespace App\Enums;

use Essa\APIToolKit\Enum\Enum;

class RoleEnum extends Enum
{
    const SUPER_ADMIN = 'super_admin';
    const ADMIN = 'admin';
    const USER = 'user';
}
