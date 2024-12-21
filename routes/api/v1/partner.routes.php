<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PartnerController;

Route::controller(PartnerController::class)
    ->name('v1.partner')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('{partner}', 'show')->name('show');
    });
