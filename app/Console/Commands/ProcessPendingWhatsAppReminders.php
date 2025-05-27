<?php

namespace App\Console\Commands;

use App\Jobs\ProcessWhatsAppReminder;
use App\Models\WhatsAppReminder;
use Illuminate\Console\Command;

class ProcessPendingWhatsAppReminders extends Command
{
    protected $signature = 'whatsapp:process-reminders';
    protected $description = 'Process pending WhatsApp reminders';

    public function handle()
    {
        $reminders = WhatsAppReminder::query()
            ->where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->get();

        $count = $reminders->count();
        $this->info("Found {$count} pending WhatsApp reminders");

        foreach ($reminders as $reminder) {
            ProcessWhatsAppReminder::dispatch($reminder)
                ->onQueue('whatsapp');
        }

        $this->info('Finished dispatching reminders for processing');
    }
}
