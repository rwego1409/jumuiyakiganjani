<?php

namespace App\Notifications;

use App\Models\AdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public AdminNotification $adminNotification)
    {
    }

    public function via($notifiable)
    {
        // Determine channels based on user preferences if needed
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->adminNotification->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->adminNotification->message)
            ->action('View Notification', route('notifications.show', [
    'notification' => $this->id,
    'utm_source' => 'email',
    'utm_medium' => 'notification',
    'utm_campaign' => 'admin_notification'
]))

            ->line('Thank you for being a valued member!')
            ->salutation('Best regards,');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->adminNotification->title,
            'message' => $this->adminNotification->message,
           'url' => route('notifications.show', ['notification' => $this->id]),
            'admin' => [
                'id' => $this->adminNotification->creator->id,
                'name' => $this->adminNotification->creator->name,
                'email' => $this->adminNotification->creator->email,
            ],
            'type' => 'admin_notification',
            'notification_id' => $this->adminNotification->id,
            'sent_at' => now()->toDateTimeString(),
            'metadata' => [
                'importance' => 'high', // Can be dynamic based on notification
                'category' => 'administrative'
            ]
        ];
    }
}