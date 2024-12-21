<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/**
 * @group Wallet
 * This is the Wallet controller
 * @authenticated
 */
class WalletController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $this->responseSuccess('', [
            'balance' => auth()->user()->mile
        ]);
    }
}
