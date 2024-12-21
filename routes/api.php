<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WalletController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(base_path('routes' . config('hub.api_version') . '/auth.routes.php'));
Route::prefix('user')->group(base_path('routes' . config('hub.api_version') . '/user.routes.php'));
Route::prefix('partner')->group(base_path('routes' . config('hub.api_version') . '/partner.routes.php'));
Route::prefix('visit-our-partner')->group(base_path('routes' . config('hub.api_version') . '/at-our-partner.routes.php'));
Route::prefix('partner-type')->group(base_path('routes' . config('hub.api_version') . '/partner-type.routes.php'));
Route::prefix('challenge')->group(base_path('routes' . config('hub.api_version') . '/challenge.routes.php'));
Route::prefix('faq')->group(base_path('routes' . config('hub.api_version') . '/faq.routes.php'));
Route::prefix('participation')->group(base_path('routes' . config('hub.api_version') . '/participation.routes.php'));
Route::prefix('share')->group(base_path('routes' . config('hub.api_version') . '/share.routes.php'));
Route::get('wallets', WalletController::class)->name('wallets')->middleware('auth:sanctum');
