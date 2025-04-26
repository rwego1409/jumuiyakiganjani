<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification as Notification;

use App\Services\NotificationService;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    public function show(Notification $notification)
    {
        // Verify the notification belongs to the current user
        if ($notification->notifiable_id !== auth()->id() || $notification->notifiable_type !== get_class(auth()->user())) {
            abort(403);
        }
        
        


        return view('notifications.show', compact('notification'));
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return back()->with('success', 'All notifications marked as read');
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['read_at' => now()]);
        return back()->with('success', 'Notification marked as read');
    }
}