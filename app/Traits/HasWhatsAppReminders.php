<?php

namespace App\Traits;

use App\Models\WhatsAppReminder;
use Carbon\Carbon;

trait HasWhatsAppReminders
{
    public function reminders()
    {
        return $this->hasMany(WhatsAppReminder::class);
    }

    public function scheduleReminder($phoneNumber, $message, Carbon $scheduledAt)
    {
        return $this->reminders()->create([
            'member_id' => $this->member_id,
            'phone_number' => $phoneNumber,
            'message' => $message,
            'scheduled_at' => $scheduledAt,
            'status' => 'pending'
        ]);
    }

    public function cancelReminder($reminderId)
    {
        return $this->reminders()
            ->where('id', $reminderId)
            ->where('status', 'pending')
            ->delete();
    }
}
