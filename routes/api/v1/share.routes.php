<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DailyShareController;

Route::controller(DailyShareController::class)
    ->name('v1.share')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('', 'store')->name('store');
        Route::get('user/history', 'userHistory')->name('user.history');
    });
