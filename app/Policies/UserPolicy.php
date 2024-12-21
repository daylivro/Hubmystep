<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\PermissionEnum;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Super admin can do anything
     */
    public function before(User $logginInUser, $ability)
    {
        if ($logginInUser->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $logginInUser): bool
    {
        return $logginInUser->can(PermissionEnum::VIEW_USER);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $logginInUser, User $user): bool
    {
        return $logginInUser->can(PermissionEnum::VIEW_USER) || $logginInUser->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $logginInUser): bool
    {
        return $logginInUser->can(PermissionEnum::CREATE_USER);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $logginInUser, User $user): bool
    {
        return $logginInUser->can(PermissionEnum::UPDATE_USER) || $logginInUser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $logginInUser, User $user): bool
    {
        return $logginInUser->can(PermissionEnum::DELETE_USER) || $logginInUser->id === $user->id;
    }

}
