<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\Jumuiya;
use App\Notifications\ChairpersonNotification;
use App\Jobs\SendWhatsAppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->jumuiya
            ->notifications()
            ->latest()
            ->paginate(10);
            
        return view('chairperson.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $members = auth()->user()
            ->jumuiya
            ->members()
            ->with('user')
            ->get();
            
        return view('chairperson.notifications.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,alert,reminder,update',
            'recipient_type' => 'required|in:all,specific',
            'member_ids' => 'required_if:recipient_type,specific|array',
            'member_ids.*' => 'exists:members,id',
            'action_url' => 'nullable|url',
            'whatsapp_reminder' => 'nullable|boolean',
        ]);

        // Get members to notify
        $members = $validated['recipient_type'] === 'all' 
            ? auth()->user()->jumuiya->members 
            : Member::whereIn('id', $validated['member_ids'])->get();

        // Create notification record
        $notification = auth()->user()->jumuiya->notifications()->create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'recipient_type' => $validated['recipient_type'],
            'member_ids' => $validated['recipient_type'] === 'specific' ? $validated['member_ids'] : [],
            'action_url' => $validated['action_url'] ?? null,
            'created_by' => auth()->id(),
            'send_whatsapp' => $request->boolean('whatsapp_reminder', false),
        ]);

        // Send notifications to members
        foreach ($members as $member) {
            if ($member->user) {
                // Send in-app notification
                $member->user->notify(new ChairpersonNotification($notification));

                // Send WhatsApp notification if enabled and phone number exists
                if ($request->boolean('whatsapp_reminder') && $member->phone) {
                    SendWhatsAppNotification::dispatch(
                        $member->phone,
                        $validated['title'],
                        $validated['message']
                    );
                }
            }
        }

        return redirect()
            ->route('chairperson.notifications.index')
            ->with('success', 'Notification sent successfully to ' . $members->count() . ' members');
    }

    public function show($id)
    {
        $notification = auth()->user()
            ->jumuiya
            ->notifications()
            ->findOrFail($id);
            
        return view('chairperson.notifications.show', compact('notification'));
    }
}
