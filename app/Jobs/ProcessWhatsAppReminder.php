<?php

namespace App\Jobs;

use App\Models\WhatsAppReminder;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessWhatsAppReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = 60;
    protected $reminder;

    public function __construct(WhatsAppReminder $reminder)
    {
        $this->reminder = $reminder;
    }

    public function handle(WhatsAppService $whatsapp)
    {
        try {
            $success = $whatsapp->sendMessage($this->reminder);

            if ($success) {
                $this->reminder->update([
                    'status' => 'sent',
                    'sent_at' => now()
                ]);
            } else {
                throw new \Exception('Failed to send WhatsApp message');
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp reminder failed', [
                'reminder_id' => $this->reminder->id,
                'error' => $e->getMessage()
            ]);

            $this->reminder->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            if ($this->attempts() >= $this->tries) {
                // Notify admin about the failure if needed
                event(new \App\Events\WhatsAppReminderFailed($this->reminder));
            }

            throw $e;
        }
    }

    public function tags()
    {
        return ['whatsapp', 'reminder:' . $this->reminder->id];
    }
}
