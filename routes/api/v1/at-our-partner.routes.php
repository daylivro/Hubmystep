<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\API\AtOurController;
use Illuminate\Support\Facades\Route;


Route::controller(AtOurController::class)
    ->name('v1.walking.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('start-walking', 'startWalking')->name('startWalking');
        Route::post('mark-as-walked', 'markAsWalked')->name('markAsWalked');
        Route::post('left-walking/{atOurPartner}', 'leftWalking')->name('leftWalking');
        Route::post('transfert-rewards', 'transfertRewards')->name('transfertRewards');
    });
