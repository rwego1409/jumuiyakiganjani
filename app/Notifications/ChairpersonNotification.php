<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\JumuiyaNotification;

class ChairpersonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected JumuiyaNotification $notification)
    {
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->notification->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->notification->message)
            ->when($this->notification->action_url, function ($message) {
                $message->action('View Details', $this->notification->action_url);
            })
            ->line('This message is from your Jumuiya chairperson.')
            ->salutation('Best regards');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'type' => $this->notification->type,
            'jumuiya_id' => $this->notification->jumuiya_id,
            'action_url' => $this->notification->action_url,
            'notification_id' => $this->notification->id,
            'sender' => [
                'id' => $this->notification->creator->id,
                'name' => $this->notification->creator->name,
                'role' => 'chairperson'
            ],
            'metadata' => [
                'sent_at' => now()->toDateTimeString(),
                'importance' => $this->notification->type === 'alert' ? 'high' : 'normal',
                'category' => 'jumuiya'
            ]
        ];
    }
}
