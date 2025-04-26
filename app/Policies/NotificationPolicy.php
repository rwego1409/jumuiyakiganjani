<?php

namespace App\Policies;

use App\Models\User;

class NotificationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    // In App\Policies\NotificationPolicy.php
public function view(User $user, DatabaseNotification $notification)
{
    return $user->id === $notification->notifiable_id;
}

public function update(User $user, DatabaseNotification $notification)
{
    return $user->id === $notification->notifiable_id;
}
}
