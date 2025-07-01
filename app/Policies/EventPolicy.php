<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow admin, chairperson, and member to view events
        return in_array($user->role, ['admin', 'chairperson', 'member']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        // Admin can view all
        if ($user->role === 'admin') return true;
        // Chairperson: can view if event is for their jumuiya or created by admin
        if ($user->role === 'chairperson') {
            $jumuiya = $user->jumuiyas()->first();
            // Event is for their jumuiya (many-to-many)
            $eventJumuiyaIds = $event->jumuiyas->pluck('id')->toArray();
            return in_array(optional($jumuiya)->id, $eventJumuiyaIds) || optional($event->creator)->role === 'admin';
        }
        // Member: can view if event is for their jumuiya or created by admin
        if ($user->role === 'member') {
            $member = $user->member;
            $eventJumuiyaIds = $event->jumuiyas->pluck('id')->toArray();
            return in_array(optional($member)->jumuiya_id, $eventJumuiyaIds) || optional($event->creator)->role === 'admin';
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        // Only allow admin to update admin events, and chairperson to update their own events
        if ($user->role === 'admin') {
            return optional($event->creator)->role === 'admin';
        }
        if ($user->role === 'chairperson') {
            return optional($event->creator)->id === $user->id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        // Only allow admin to delete admin events, and chairperson to delete their own events
        if ($user->role === 'admin') {
            return optional($event->creator)->role === 'admin';
        }
        if ($user->role === 'chairperson') {
            return optional($event->creator)->id === $user->id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        return true;
    }
}
