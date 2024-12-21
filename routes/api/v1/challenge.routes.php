<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChallengeController;

Route::controller(ChallengeController::class)
    ->name('v1.challenge')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('{challenge}', 'show')->name('show');
        Route::post('/add/participant', 'addParticipant')->name('become.participant')->middleware('auth:sanctum');
    });
