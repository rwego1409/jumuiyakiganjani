<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
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
};
