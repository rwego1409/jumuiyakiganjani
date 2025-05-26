<?php

namespace App\Console\Commands;

use App\Models\WhatsAppReminder;
use Illuminate\Console\Command;

class CleanupWhatsAppReminders extends Command
{
    protected $signature = 'whatsapp:cleanup-reminders';
    protected $description = 'Clean up old WhatsApp reminders';

    public function handle()
    {
        // Delete sent reminders older than 30 days
        $deleted = WhatsAppReminder::where('status', 'sent')
            ->where('sent_at', '<', now()->subDays(30))
            ->delete();

        $this->info("Deleted {$deleted} old reminders");

        // Delete failed reminders older than 7 days
        $deleted = WhatsAppReminder::where('status', 'failed')
            ->where('created_at', '<', now()->subDays(7))
            ->delete();

        $this->info("Deleted {$deleted} failed reminders");

        return Command::SUCCESS;
    }
}
