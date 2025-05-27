<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettingsTable extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.app_name', 'Jumuiya Kiganjani');
        $this->migrator->add('general.app_url', config('app.url'));
        $this->migrator->add('general.support_email', config('mail.from.address'));
        
        // Notification settings
        $this->migrator->add('general.email_enabled', true);
        $this->migrator->add('general.whatsapp_enabled', false);
        $this->migrator->add('general.sms_enabled', false);
        
        // Contribution reminder settings
        $this->migrator->add('general.contribution_reminders_enabled', true);
        $this->migrator->add('general.reminder_days', 3);
        
        // Meeting reminder settings
        $this->migrator->add('general.meeting_reminders_enabled', true);
        $this->migrator->add('general.meeting_reminder_hours', 24);
    }
}
