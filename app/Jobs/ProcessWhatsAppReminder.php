<?php

namespace App\Jobs;

use App\Models\WhatsAppReminder;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWhatsAppReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reminder;

    public function __construct(WhatsAppReminder $reminder)
    {
        $this->reminder = $reminder;
    }

    public function handle(WhatsAppService $whatsapp)
    {
        $whatsapp->sendMessage($this->reminder);
    }
}
