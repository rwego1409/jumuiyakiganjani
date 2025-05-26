<?php

namespace App\Console\Commands;

use App\Jobs\ProcessWhatsAppReminder;
use App\Models\WhatsAppReminder;
use Illuminate\Console\Command;

class ProcessWhatsAppReminders extends Command
{
    protected $signature = 'whatsapp:process-reminders';
    protected $description = 'Process pending WhatsApp reminders';

    public function handle()
    {
        $pendingReminders = WhatsAppReminder::pending()->get();

        $this->info("Found {$pendingReminders->count()} pending reminders");

        foreach ($pendingReminders as $reminder) {
            ProcessWhatsAppReminder::dispatch($reminder);
            $this->line("Dispatched reminder #{$reminder->id} for processing");
        }

        return Command::SUCCESS;
    }
}
