<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    private $settings;
    
    public function __construct(GeneralSettings $settings)
    {
        $this->settings = $settings;
    }

    public function index()
    {
        $jumuiya = Auth::user()->jumuiya;
        $settings = [
            'notifications' => [
                'email_enabled' => $this->settings->email_enabled ?? true,
                'whatsapp_enabled' => $this->settings->whatsapp_enabled ?? false,
                'sms_enabled' => $this->settings->sms_enabled ?? false
            ],
            'contribution_reminders' => [
                'enabled' => $this->settings->contribution_reminders_enabled ?? true,
                'reminder_days' => $this->settings->reminder_days ?? 3
            ],
            'meeting_reminders' => [
                'enabled' => $this->settings->meeting_reminders_enabled ?? true,
                'reminder_hours' => $this->settings->meeting_reminder_hours ?? 24
            ]
        ];

        return view('chairperson.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'notifications.email_enabled' => 'boolean',
            'notifications.whatsapp_enabled' => 'boolean',
            'notifications.sms_enabled' => 'boolean',
            'contribution_reminders.enabled' => 'boolean',
            'contribution_reminders.reminder_days' => 'integer|min:1|max:30',
            'meeting_reminders.enabled' => 'boolean',
            'meeting_reminders.reminder_hours' => 'integer|min:1|max:168'
        ]);

        $this->settings->email_enabled = $validated['notifications']['email_enabled'];
        $this->settings->whatsapp_enabled = $validated['notifications']['whatsapp_enabled'];
        $this->settings->sms_enabled = $validated['notifications']['sms_enabled'];
        $this->settings->contribution_reminders_enabled = $validated['contribution_reminders']['enabled'];
        $this->settings->reminder_days = $validated['contribution_reminders']['reminder_days'];
        $this->settings->meeting_reminders_enabled = $validated['meeting_reminders']['enabled'];
        $this->settings->meeting_reminder_hours = $validated['meeting_reminders']['reminder_hours'];
        
        $this->settings->save();

        return back()->with('success', 'Settings updated successfully');
    }
}
