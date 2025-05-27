<?php

namespace App\Events;

use App\Models\WhatsAppReminder;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhatsAppReminderFailed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public WhatsAppReminder $reminder
    ) {}
}
