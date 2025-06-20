<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationCountComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $unreadCount = Auth::user()->unreadNotifications()->count();
            $view->with('unreadNotificationsCount', $unreadCount);
        }
    }
}
