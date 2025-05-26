<?php

namespace App\Policies;

use App\Models\Jumuiya;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JumuiyaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow admins and super admins to view all Jumuiyas
        return $user->isAdmin() || $user->isSuper_Admin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Jumuiya $jumuiya): bool
    {
        // Allow admins and super admins to view any Jumuiya
        if ($user->isAdmin() || $user->isSuper_Admin()) {
            return true;
        }

        // Allow chairperson to view their own Jumuiya
        if ($user->isChairperson()) {
            return $user->id === $jumuiya->chairperson_id;
        }

        // Allow members to view their Jumuiya
        if ($user->isMember()) {
            return $user->member && $user->member->jumuiya_id === $jumuiya->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only super admins can create Jumuiyas
        return $user->isSuper_Admin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Jumuiya $jumuiya): bool
    {
        // Only super admins can update Jumuiyas
        return $user->isSuper_Admin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Jumuiya $jumuiya): bool
    {
        // Only super admins can delete Jumuiyas
        return $user->isSuper_Admin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Jumuiya $jumuiya): bool
    {
        // Only super admins can restore Jumuiyas
        return $user->isSuper_Admin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Jumuiya $jumuiya): bool
    {
        // Only super admins can permanently delete Jumuiyas
        return $user->isSuper_Admin();
    }
}
