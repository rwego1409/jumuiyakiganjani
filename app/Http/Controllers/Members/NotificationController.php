<?php
namespace App\Http\Controllers\Members;

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
        $notifications = $user->notifications()->latest()->paginate(10);

        return view('notifications.index', [
            'notifications' => $notifications,
            'role' => $user->role
        ]);
    }

    public function show($id)
    {
        // Only allow showing admin or jumuiya notification by id
        $adminNotification = \App\Models\AdminNotification::find($id);
        if ($adminNotification) {
            return view('notifications.show', ['notification' => $adminNotification]);
        }
        $member = auth()->user()->member;
        $jumuiyaId = $member ? $member->jumuiya_id : null;
        $jumuiyaNotification = $jumuiyaId ? \App\Models\JumuiyaNotification::where('jumuiya_id', $jumuiyaId)->find($id) : null;
        if ($jumuiyaNotification) {
            return view('notifications.show', ['notification' => $jumuiyaNotification]);
        }
        abort(404);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'All notifications marked as read');
    }   
}