<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::controller(UserController::class)
    ->middleware('auth:sanctum')
    ->name('v1.user')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::put('{user}', 'update')->name('update');
    });
