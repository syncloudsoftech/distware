<?php

namespace App\Policies;

use App\Models\Update;
use App\Models\User;

class UpdatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view all updates');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Update $update): bool
    {
        return $user->can('view update');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create update');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Update $update): bool
    {
        return $user->can('update update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Update $update): bool
    {
        return $user->can('delete update');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Update $update): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Update $update): bool
    {
        //
    }
}
