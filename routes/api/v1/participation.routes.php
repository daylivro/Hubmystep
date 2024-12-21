<?php

use App\Http\Controllers\API\ParticipationController;
use Illuminate\Support\Facades\Route;

Route::controller(ParticipationController::class)
    ->middleware('auth:sanctum')
    ->name('v1.participation')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('', 'store')->name('store');
        Route::post('generate-payment', 'payment')->name('payment');
        Route::post('mark-as-paid', 'markAsPaid')->name('markAsPaid');
    });
