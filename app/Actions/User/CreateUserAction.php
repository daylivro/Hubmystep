<?php

namespace App\Actions\User;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Arr;
use App\Events\User\UserCreated;
use App\Notifications\WelcomeNotification;
use App\Services\ReferalCodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(array $data): User
    {
        DB::beginTransaction();

        $newUser = User::create([
            'first_name' => Arr::get($data, 'first_name'),
            'last_name' => Arr::get($data, 'last_name'),
            'email' => Arr::get($data, 'email'),
            'phone' => Arr::get($data, 'phone'),
            'password' => Hash::make(Arr::get($data, 'password')),
            'address' => Arr::get($data, 'address'),
            'location' => Arr::get($data, 'location', []),
            'referal_code' => ReferalCodeService::generateReferalCode(),
        ]);

        DB::commit();

        UserCreated::dispatch($newUser);
        $newUser->notify(new WelcomeNotification($newUser->referal_code));
        $newUser->assignRole(RoleEnum::USER);
        return $newUser;
    }
}
