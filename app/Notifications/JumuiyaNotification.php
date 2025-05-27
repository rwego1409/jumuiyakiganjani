<?php

namespace App\Notifications;

use App\Models\JumuiyaNotification as JumuiyaNotificationModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JumuiyaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public JumuiyaNotificationModel $jumuiyaNotification)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->jumuiyaNotification->title)
            ->greeting('Hello ' . $notifiable->name)
            ->line($this->jumuiyaNotification->message);
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => $this->jumuiyaNotification->title,
            'message' => $this->jumuiyaNotification->message,
            'type' => $this->jumuiyaNotification->type,
            'url' => $this->jumuiyaNotification->action_url,
            'jumuiya' => [
                'id' => $this->jumuiyaNotification->jumuiya_id,
                'name' => $this->jumuiyaNotification->jumuiya->name,
            ],
            'chairperson' => [
                'id' => $this->jumuiyaNotification->created_by,
                'name' => $this->jumuiyaNotification->creator->name,
            ],
        ];
    }
}
