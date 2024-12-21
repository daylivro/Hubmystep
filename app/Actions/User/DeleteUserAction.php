<?php

namespace App\Actions\User;

class DeleteUserAction
{
    public function execute(User $user): void
    {
        DB::beginTransaction();

        $user->delete();

        DB::commit();
    }
}
