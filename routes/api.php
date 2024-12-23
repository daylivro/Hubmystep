<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\WithdrawalRequestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(base_path('routes/api/v1/auth.routes.php'));
Route::prefix('user')->group(base_path('routes/api/v1/user.routes.php'));
Route::prefix('partner')->group(base_path('routes/api/v1/partner.routes.php'));
Route::prefix('visit-our-partner')->group(base_path('routes/api/v1/at-our-partner.routes.php'));
Route::prefix('partner-type')->group(base_path('routes/api/v1/partner-type.routes.php'));
Route::prefix('challenge')->group(base_path('routes/api/v1/challenge.routes.php'));
Route::prefix('faq')->group(base_path('routes/api/v1/faq.routes.php'));
Route::prefix('participation')->group(base_path('routes/api/v1/participation.routes.php'));
Route::prefix('share')->group(base_path('routes/api/v1/share.routes.php'));
Route::get('wallets', WalletController::class)->name('wallets')->middleware('auth:sanctum');
Route::apiResource('withdrawal-requests', WithdrawalRequestController::class)
    ->only(['index', 'store'])
    ->middleware('auth:sanctum');
