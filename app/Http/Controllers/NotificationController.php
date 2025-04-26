<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->latest()
            ->paginate(10);
            
        return view('notifications.index', compact('notifications'));
    }

    public function show(DatabaseNotification $notification)
    {
        // Verify ownership using Laravel's authorization
        $this->authorize('view', $notification);

        // Mark as read if unread
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read');
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $this->authorize('update', $notification);
        
        $notification->markAsRead();
        return back()->with('success', 'Notification marked as read');
    }
}