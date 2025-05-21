<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database']; // Channels you want to use
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('This is a test notification')
                    ->action('View Dashboard', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'This is a test notification',
            'url' => url('/')
        ];
    }
}