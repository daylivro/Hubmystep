<?php

namespace App\Http\Controllers;

use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use ApiResponse, AuthorizesRequests;
}
