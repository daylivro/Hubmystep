<?php

return [
    'api_version' => env('HUB_API_VERSION',  null),
    'system_admin_email' => env('HUB_SYSTEM_ADMIN_EMAIL', null),
    'system_admin_password' => env('HUB_SYSTEM_ADMIN_PASSWORD', null),
    'number_of_password_histories' => env('HUB_NUMBER_OF_PASSWORD_HISTORIES', 5),
    'min_withdrawal_mile' => env('HUB_MIN_WITHDRAWAL_MILE', 2000),
];
