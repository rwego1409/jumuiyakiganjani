<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResourcePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow admin, chairperson, and member to view resources
        return in_array($user->role, ['admin', 'chairperson', 'member']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Resource $resource): bool
    {
        // Admin can view all
        if ($user->role === 'admin') return true;
        // Chairperson: can view if resource is for their jumuiya or created by admin
        if ($user->role === 'chairperson') {
            $jumuiya = $user->jumuiyas()->first();
            $isForJumuiya = $resource->jumuiya_id === optional($jumuiya)->id;
            $isAdminCreated = optional($resource->creator)->role === 'admin';
            return $isForJumuiya || $isAdminCreated;
        }
        // Member: can view if resource is for their jumuiya or created by admin
        if ($user->role === 'member') {
            $member = $user->member;
            $isForJumuiya = $resource->jumuiya_id === optional($member)->jumuiya_id;
            $isAdminCreated = optional($resource->creator)->role === 'admin';
            return $isForJumuiya || $isAdminCreated;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Resource $resource): bool
    {
        // Admin can update only their own uploads (jumuiya_id null and created_by matches)
        if ($user->role === 'admin') {
            return $resource->jumuiya_id === null && $resource->created_by === $user->id;
        }
        // Chairperson can update only their own uploads
        if ($user->role === 'chairperson') {
            $jumuiya = $user->jumuiyas()->first();
            return $resource->jumuiya_id === optional($jumuiya)->id && $resource->created_by === $user->id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resource $resource): bool
    {
        // Admin can delete only their own uploads (jumuiya_id null and created_by matches)
        if ($user->role === 'admin') {
            return $resource->jumuiya_id === null && $resource->created_by === $user->id;
        }
        // Chairperson can delete only their own uploads
        if ($user->role === 'chairperson') {
            $jumuiya = $user->jumuiyas()->first();
            return $resource->jumuiya_id === optional($jumuiya)->id && $resource->created_by === $user->id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Resource $resource): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Resource $resource): bool
    {
        return false;
    }
}
