<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::orderBy('created_at', 'desc')->paginate(10);
        return view('super_admin.notifications.index', [
            'notifications' => $notifications,
            'routePrefix' => 'super_admin.notifications.'
        ]);
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('super_admin.notifications.create', [
            'users' => $users,
            'routePrefix' => 'super_admin.notifications.'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,alert,reminder,update',
            'recipient_type' => 'required|in:all,specific',
            'user_ids' => 'required_if:recipient_type,specific|array',
            'user_ids.*' => 'exists:users,id',
            'action_url' => 'nullable|url',
        ]);

        $notification = AdminNotification::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'recipients' => [$validated['recipient_type']],
            'user_ids' => $validated['recipient_type'] === 'specific' ? $validated['user_ids'] : [],
            'action_url' => $validated['action_url'] ?? null,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('super_admin.notifications.create')
            ->with([
                'success' => 'Notification has been successfully sent!',
                'notification_id' => $notification->id
            ]);
    }

    public function show($id)
    {
        $notification = AdminNotification::findOrFail($id);
        return view('super_admin.notifications.show', [
            'notification' => $notification,
            'routePrefix' => 'super_admin.notifications.'
        ]);
    }

    public function markAllAsRead()
    {
        // Mark all as read logic
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
