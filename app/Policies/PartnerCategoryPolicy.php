<?php

namespace App\Policies;

use App\Models\PartnerCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PartnerCategoryPolicy
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
        return $logginInUser->can(PermissionEnum::VIEW_PARTNER_CATEGORY);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $logginInUser, PartnerCategory $partnerCategory): bool
    {
        return $logginInUser->can(PermissionEnum::VIEW_PARTNER_CATEGORY);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $logginInUser): bool
    {
        return $logginInUser->can(PermissionEnum::CREATE_PARTNER_CATEGORY);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $logginInUser, PartnerCategory $partnerCategory): bool
    {
        return $logginInUser->can(PermissionEnum::UPDATE_PARTNER_CATEGORY);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PartnerCategory $partnerCategory): bool
    {
        return $logginInUser->can(PermissionEnum::DELETE_PARTNER_CATEGORY);
    }

}
