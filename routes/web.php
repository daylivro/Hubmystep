<?php

use App\Http\Controllers\ProfileController;
use App\Models\AtOurPartner;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/hub')->name('login');
Route::get('/scan/{hash}/partner/{partner}/user/{user}', function ($hash, $partner, $user) {
    $challenge = AtOurPartner::where([
        'user_id' => \App\Models\User::where('username', $user)->first()->id,
        'partner_id' => \App\Models\Partner::where('slug', $partner)->first()->id,
        'done' => true,
        'scan_at' => null,
    ])->first();

    if (!$challenge) {
        abort(404);
    }

    $challenge->scan_at = now();
    $challenge->save();
})->name('scan.generate');
