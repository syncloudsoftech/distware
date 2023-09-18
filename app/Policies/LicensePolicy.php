<?php

namespace App\Policies;

use App\Models\License;
use App\Models\User;

class LicensePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view all licenses');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, License $license): bool
    {
        return $user->can('view license');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create license');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, License $license): bool
    {
        return $user->can('update license');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, License $license): bool
    {
        return $user->can('delete license');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, License $license): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, License $license): bool
    {
        //
    }
}
