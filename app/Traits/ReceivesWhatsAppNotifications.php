<?php

namespace App\Traits;

trait ReceivesWhatsAppNotifications
{
    public function routeNotificationForWhatsapp()
    {
        return $this->phone_number; // Assumes the model has a phone_number field
    }

    public function canReceiveWhatsAppNotifications(): bool
    {
        return !empty($this->phone_number) && $this->whatsapp_notifications_enabled;
    }
}
