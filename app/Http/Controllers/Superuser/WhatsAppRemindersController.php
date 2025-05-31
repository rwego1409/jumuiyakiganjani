<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppReminder;
use Illuminate\Http\Request;

class WhatsAppRemindersController extends Controller
{
    public function index()
    {
        $reminders = WhatsAppReminder::orderByDesc('scheduled_at')->paginate(15);
        return view('superuser.whatsapp_reminders.index', compact('reminders'));
    }

    public function create()
    {
        return view('superuser.whatsapp_reminders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'scheduled_at' => 'required|date|after:now',
        ]);
        WhatsAppReminder::create($validated);
        return redirect()->route('superuser.whatsapp_reminders.index')->with('success', 'Reminder created successfully.');
    }

    public function edit(WhatsAppReminder $whatsapp_reminder)
    {
        return view('superuser.whatsapp_reminders.edit', ['reminder' => $whatsapp_reminder]);
    }

    public function update(Request $request, WhatsAppReminder $whatsapp_reminder)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'scheduled_at' => 'required|date|after:now',
        ]);
        $whatsapp_reminder->update($validated);
        return redirect()->route('superuser.whatsapp_reminders.index')->with('success', 'Reminder updated successfully.');
    }

    public function destroy(WhatsAppReminder $whatsapp_reminder)
    {
        $whatsapp_reminder->delete();
        return redirect()->route('superuser.whatsapp_reminders.index')->with('success', 'Reminder deleted successfully.');
    }
}
