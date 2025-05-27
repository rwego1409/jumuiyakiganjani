<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Services\WhatsAppService;
use App\Models\WhatsAppReminder;

class WhatsAppChannel
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            throw new \Exception('Notification class must implement toWhatsApp method');
        }

        $message = $notification->toWhatsApp($notifiable);
        
        if (!$notifiable->routeNotificationFor('whatsapp')) {
            return;
        }

        $reminder = WhatsAppReminder::create([
            'phone_number' => $notifiable->routeNotificationFor('whatsapp'),
            'message' => $message,
            'status' => 'pending',
            'user_id' => $notifiable->id,
            'type' => get_class($notification)
        ]);

        return $this->whatsapp->sendMessage($reminder);
    }
}
