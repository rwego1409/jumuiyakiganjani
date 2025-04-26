<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class DummyNotification extends Notification
{
    protected $message;
    protected $type;

    public function __construct($message, $type = 'info')
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'read_at' => null
        ];
    }
}
