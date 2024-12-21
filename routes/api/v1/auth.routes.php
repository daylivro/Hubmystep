<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::controller(AuthController::class)
    ->name('v1.auth.')
    ->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
        Route::post('password/forgot', 'passwordForgot')->name('password.forgot');
        Route::post('password/reset', 'passwordReset')->name('password.reset');
        Route::post('otp/resend', 'resendOtp')->name('otp.resend');
        Route::post('otp/verify', 'verifyOtp')->name('otp.verify');
        Route::post('logout', 'logout')->name('logout')->middleware('auth:sanctum');
    });
