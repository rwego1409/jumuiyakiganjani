<?php

namespace App\Console\Commands;

use App\Models\WhatsAppReminder;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MonitorWhatsAppDelivery extends Command
{
    protected $signature = 'whatsapp:monitor-delivery';
    protected $description = 'Monitor the delivery status of WhatsApp messages';

    public function handle()
    {
        $this->info('Starting WhatsApp delivery monitoring...');

        $pendingReminders = WhatsAppReminder::where('status', 'pending')
            ->where('created_at', '>', now()->subHours(24))
            ->get();

        if ($pendingReminders->isEmpty()) {
            $this->info('No pending reminders to monitor.');
            return;
        }

        $this->info("Found {$pendingReminders->count()} pending reminders.");

        foreach ($pendingReminders as $reminder) {
            try {
                // Implement the actual status check here when you have the WhatsApp Business API
                // For now, we'll just mark old messages as failed
                if ($reminder->created_at->diffInMinutes(now()) > 30) {
                    $reminder->update([
                        'status' => 'failed',
                        'error_message' => 'Message delivery timeout'
                    ]);

                    $this->warn("Reminder {$reminder->id} marked as failed due to timeout.");
                    
                    // You could implement a retry mechanism here if needed
                    if ($reminder->attempts < 3) {
                        // Retry sending the message
                        dispatch(new \App\Jobs\ProcessWhatsAppReminder($reminder));
                        $this->info("Retrying reminder {$reminder->id}");
                    }
                }
            } catch (\Exception $e) {
                Log::error("Error monitoring WhatsApp reminder {$reminder->id}", [
                    'error' => $e->getMessage(),
                    'reminder' => $reminder->toArray()
                ]);

                $this->error("Error monitoring reminder {$reminder->id}: {$e->getMessage()}");
            }
        }

        $this->info('WhatsApp delivery monitoring completed.');
    }
}
