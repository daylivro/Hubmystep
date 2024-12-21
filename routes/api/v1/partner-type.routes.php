<?php
namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PartnerController;


Route::controller(PartnerController::class)
    ->name('v1.getTypes')
    ->group(function () {
        Route::get('', 'getTypes')->name('index');
        Route::get('{partnerCategory}', 'showType')->name('show');
    });
