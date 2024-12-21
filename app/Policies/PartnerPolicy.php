<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Partner;
use App\Enums\PermissionEnum;
use Illuminate\Auth\Access\Response;

class PartnerPolicy
{
    /**
     * Super admin can do anything
     */
    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $logginInUser): bool
    {
        return $logginInUser->can(PermissionEnum::VIEW_PARTNER);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $logginInUser, Partner $partner): bool
    {
        return $logginInUser->can(PermissionEnum::VIEW_PARTNER);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $logginInUser): bool
    {
        return $logginInUser->can(PermissionEnum::CREATE_PARTNER);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $logginInUser, Partner $partner): bool
    {
        return $logginInUser->can(PermissionEnum::UPDATE_PARTNER);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Partner $partner): bool
    {
        return $logginInUser->can(PermissionEnum::DELETE_PARTNER);
    }

}
