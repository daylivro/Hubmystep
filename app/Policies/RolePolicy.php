<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Enums\PermissionEnum;
use Illuminate\Auth\Access\Response;

class RolePolicy
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
        return $logginInUser->can(PermissionEnum::VIEW_ROLE);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $logginInUser, Role $role): bool
    {
        return $logginInUser->can(PermissionEnum::VIEW_ROLE);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $logginInUser): bool
    {
        return $logginInUser->can(PermissionEnum::CREATE_ROLE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        return $logginInUser->can(PermissionEnum::UPDATE_ROLE);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        return $logginInUser->can(PermissionEnum::DELETE_ROLE);
    }

}
