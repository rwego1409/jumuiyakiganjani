<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\User;
use App\Notifications\AdminCreatedNotification;
use Illuminate\Http\Request;
use App\Jobs\DispatchNotifications;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class NotificationController extends Controller
{
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('admin.notifications.create', compact('users'));
    }

   // app/Http/Controllers/Admin/NotificationController.php

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

    // Dispatch job to send notifications
    DispatchNotifications::dispatch($notification);

    return redirect()
        ->route('admin.notifications.create')
        ->with([
            'success' => 'Notification has been successfully sent!',
            'notification_id' => $notification->id
        ]);
}
    protected function sendNotifications(AdminNotification $notification)
    {
        $users = $this->getRecipients($notification);
        
        foreach ($users as $user) {
            $user->notify(new AdminCreatedNotification($notification));
        }
    }

    protected function getRecipients(AdminNotification $notification)
    {
        if (in_array('all', $notification->recipients)) {
            return User::where('id', '!=', $notification->created_by)->get();
        }

        return User::whereIn('id', $notification->user_ids)->get();
    }

   public function show($id)
{
    // Retrieve the notification from the database using the correct model
    $notification = AdminNotification::findOrFail($id); // Use AdminNotification here

    return view('admin.notifications.show', compact('notification'));
}
public function index()
{
    // Fetch all notifications with pagination
    $notifications = AdminNotification::orderBy('created_at', 'desc')->paginate(10); // Pagination is set to 10 per page

    // Return the view with paginated notifications
    return view('admin.notifications.index', compact('notifications'));
}

}