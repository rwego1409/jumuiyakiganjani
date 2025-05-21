<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role; // Get the role from the authenticated user
        $notifications = $user->notifications()
            ->latest()
            ->paginate(10);
            
        return view('notifications.index', compact('notifications', 'role'));
    }
    
    // app/Http/Controllers/NotificationController.php

public function show($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    
    // Mark as read when viewed
    if ($notification->unread()) {
        $notification->markAsRead();
        
        // Track the view if needed
        \App\Models\NotificationView::create([
            'user_id' => auth()->id(),
            'notification_id' => $notification->id,
            'viewed_at' => now()
        ]);
    }
    
    // Get related admin notification if exists
    $adminNotification = null;
    if (isset($notification->data['notification_id'])) {
        $adminNotification = \App\Models\AdminNotification::find(
            $notification->data['notification_id']
        );
    }
    
    return view('notifications.show', [
        'notification' => $notification,
        'adminNotification' => $adminNotification
    ]);
}

public function markAsRead($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    
    return response()->json([
        'success' => true,
        'unread_count' => auth()->user()->unreadNotifications->count()
    ]);
}

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read');
    }

   
}