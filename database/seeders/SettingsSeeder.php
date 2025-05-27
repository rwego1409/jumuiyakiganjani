<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Settings\GeneralSettings;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = app(GeneralSettings::class);
        
        $settings->app_name = 'Jumuiya Kiganjani';
        $settings->app_url = config('app.url');
        $settings->support_email = config('mail.from.address');
        
        // Notification settings
        $settings->email_enabled = true;
        $settings->whatsapp_enabled = false;
        $settings->sms_enabled = false;
        
        // Contribution reminder settings
        $settings->contribution_reminders_enabled = true;
        $settings->reminder_days = 3;
        
        // Meeting reminder settings
        $settings->meeting_reminders_enabled = true;
        $settings->meeting_reminder_hours = 24;
        
        $settings->save();
    }
}
