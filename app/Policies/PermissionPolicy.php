<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;
use App\Enums\PermissionEnum;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
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
        return $logginInUser->can(PermissionEnum::VIEW_PERMISSION);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $logginInUser, Permission $permission): bool
    {
        return $logginInUser->can(PermissionEnum::VIEW_PERMISSION);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $logginInUser): bool
    {
        return $logginInUser->can(PermissionEnum::CREATE_PERMISSION);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $logginInUser, Permission $permission): bool
    {
        return $logginInUser->can(PermissionEnum::UPDATE_PERMISSION);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $logginInUser->can(PermissionEnum::DELETE_PERMISSION);
    }

}
