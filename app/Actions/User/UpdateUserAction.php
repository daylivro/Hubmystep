<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateUserAction
{
    public function execute(array $data, User $user): User
    {
        DB::beginTransaction();

        $user->update([
            'first_name' => Arr::get($data, 'first_name'),
            'last_name' => Arr::get($data, 'last_name'),
            'email' => Arr::get($data, 'email'),
            'phone' => Arr::get($data, 'phone'),
            'address' => Arr::get($data, 'address'),
            'location' => Arr::get($data, 'location'),
        ]);

        DB::commit();

        return $user;
    }
}
