<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jumuiya;
use App\Models\Member;
use App\Models\JumuiyaNotification;
use App\Notifications\ChairpersonNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class NotificationController extends Controller
{
    protected function getJumuiya()
    {
        return Jumuiya::where('chairperson_id', auth()->id())->first();
    }

    public function index()
    {
        $user = auth()->user();
        $jumuiya = $this->getJumuiya();

        // Sent notifications - convert to object-like for Blade compatibility
        $sentNotifications = JumuiyaNotification::where('created_by', $user->id)
            ->where('jumuiya_id', $jumuiya ? $jumuiya->id : 0)
            ->latest()
            ->get()
            ->map(function ($notification) {
                $fake = new \stdClass();
                $fake->id = $notification->id;
                $fake->data = [
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'recipient_type' => $notification->recipient_type,
                    'member_ids' => $notification->member_ids,
                ];
                $fake->created_at = $notification->created_at;
                $fake->read_at = null;
                $fake->type = 'sent';
                $fake->is_sent = true;
                return $fake;
            });

        // Received notifications - real Laravel notification objects
        $receivedNotifications = DatabaseNotification::where('notifiable_type', User::class)
            ->where('notifiable_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($notification) {
                $notification->type = 'received'; // Tag type for UI
                return $notification;
            });

        // Merge both, sort by time
        $allNotifications = $sentNotifications->concat($receivedNotifications)
            ->sortByDesc('created_at')
            ->values();

        // Manual pagination
        $page = request()->get('page', 1);
        $perPage = 10;
        $notifications = new LengthAwarePaginator(
            $allNotifications->forPage($page, $perPage),
            $allNotifications->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('chairperson.notifications.index', [
            'notifications' => $notifications,
            'jumuiya' => $jumuiya
        ]);
    }

    public function show($id)
    {
        $notification = DatabaseNotification::where('notifiable_type', User::class)
            ->where('notifiable_id', auth()->id())
            ->findOrFail($id);
        
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        if (isset($notification->data['contribution_id'])) {
            return redirect()->route('chairperson.contributions.show', $notification->data['contribution_id']);
        }

        return redirect()->route('chairperson.notifications.index')
            ->with('success', 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        DatabaseNotification::where('notifiable_type', User::class)
            ->where('notifiable_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        return redirect()->route('chairperson.notifications.index')
            ->with('success', 'All notifications marked as read');
    }

    public function create()
    {
        $jumuiya = $this->getJumuiya();
        if (!$jumuiya) {
            return redirect()->route('chairperson.notifications.index')
                ->with('error', 'You need to be assigned to a Jumuiya first.');
        }

        $members = $jumuiya->members()->with('user')->get();
        return view('chairperson.notifications.create', compact('members'));
    }

    public function store(Request $request)
    {
        $jumuiya = $this->getJumuiya();
        if (!$jumuiya) {
            return back()->with('error', 'You need to be assigned to a Jumuiya first.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,alert,reminder,update',
            'recipient_type' => 'required|in:all,specific',
            'member_ids' => 'required_if:recipient_type,specific|array',
            'member_ids.*' => 'exists:members,id',
            'action_url' => 'nullable|url'
        ]);

        // Store Jumuiya-level notification
        $notificationData = [
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'recipient_type' => $validated['recipient_type'],
            'jumuiya_id' => $jumuiya->id,
            'created_by' => auth()->id(),
            'action_url' => $validated['action_url'] ?? null,
        ];

        if ($validated['recipient_type'] === 'specific') {
            $notificationData['member_ids'] = $validated['member_ids'];
        }

        $notification = JumuiyaNotification::create($notificationData);

        // Determine recipients
        $members = $validated['recipient_type'] === 'all'
            ? $jumuiya->members()->with('user')->get()
            : Member::whereIn('id', $validated['member_ids'])
                ->where('jumuiya_id', $jumuiya->id)
                ->with('user')
                ->get();

        // Send out Laravel notifications
        foreach ($members as $member) {
            if ($member->user) {
                $member->user->notify(new ChairpersonNotification($notification));
            }
        }

        return redirect()->route('chairperson.notifications.index')
            ->with('success', 'Notification sent successfully to ' . $members->count() . ' members');
    }
    public function edit($id)
    {
        $jumuiya = $this->getJumuiya();
        $notification = \App\Models\JumuiyaNotification::where('id', $id)
            ->where('jumuiya_id', $jumuiya ? $jumuiya->id : 0)
            ->firstOrFail();
        $members = $jumuiya ? $jumuiya->members()->with('user')->get() : collect();
        return view('chairperson.notifications.edit', compact('notification', 'members'));
    }

    public function update(Request $request, $id)
    {
        $jumuiya = $this->getJumuiya();
        $notification = \App\Models\JumuiyaNotification::where('id', $id)
            ->where('jumuiya_id', $jumuiya ? $jumuiya->id : 0)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,alert,reminder,update',
            'recipient_type' => 'required|in:all,specific',
            'member_ids' => 'required_if:recipient_type,specific|array',
            'member_ids.*' => 'exists:members,id',
            'action_url' => 'nullable|url'
        ]);

        $notification->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'recipient_type' => $validated['recipient_type'],
            'action_url' => $validated['action_url'] ?? null,
            'member_ids' => $validated['recipient_type'] === 'specific' ? $validated['member_ids'] : null,
        ]);

        return redirect()->route('chairperson.notifications.index')
            ->with('success', 'Notification updated successfully.');
    }
    public function destroy($id)
    {
        $jumuiya = $this->getJumuiya();
        $notification = \App\Models\JumuiyaNotification::where('id', $id)
            ->where('jumuiya_id', $jumuiya ? $jumuiya->id : 0)
            ->firstOrFail();
        $notification->delete();
        return redirect()->route('chairperson.notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }
}
