<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $role = $user->role;
    $notifications = $user->notifications()
        ->latest()
        ->paginate(10);
        
    return view('notifications.index', compact('notifications', 'role'));
}

public function show($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    
    // Mark as read if unread
    if ($notification->unread()) {
        $notification->markAsRead();
    }
    
    // Handle different notification types
    if (isset($notification->data['contribution_id'])) {
        return redirect()->route('member.contributions.show', $notification->data['contribution_id']);
    }
    
    // Default return to notifications index
    return redirect()->route('notifications.index')
        ->with('success', 'Notification marked as read');
}

public function markAllAsRead()
{
    auth()->user()->unreadNotifications->markAsRead();
    
    return back()->with('success', 'All notifications marked as read');
}   
}