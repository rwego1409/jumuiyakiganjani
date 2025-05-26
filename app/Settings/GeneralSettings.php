<?php

namespace App\Settings;

// app/Settings/GeneralSettings.php
use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $app_name;
    public string $app_url;
    public string $support_email;
    
    // Notification settings
    public bool $email_enabled;
    public bool $whatsapp_enabled;
    public bool $sms_enabled;
    
    // Contribution reminder settings
    public bool $contribution_reminders_enabled;
    public int $reminder_days;
    
    // Meeting reminder settings
    public bool $meeting_reminders_enabled;
    public int $meeting_reminder_hours;

    public static function group(): string
    {
        return 'general';
    }

    public static function defaults(): array
    {
        return [
            'app_name' => 'jumuiya_kiganjani',
            'app_url' => env('APP_URL', 'http://localhost'),
            'support_email' => 'support@example.com',
            'email_enabled' => true,
            'whatsapp_enabled' => false,
            'sms_enabled' => false,
            'contribution_reminders_enabled' => true,
            'reminder_days' => 3,
            'meeting_reminders_enabled' => true,
            'meeting_reminder_hours' => 24,
        ];
    }
}