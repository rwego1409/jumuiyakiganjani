<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChairpersonActionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $title,
        protected string $message,
        protected string $actionText,
        protected string $actionUrl,
        protected User $chairperson
    ) {}

    public function via($notifiable): array
    {
        $channels = ['mail', 'database'];
        
        if ($notifiable->routeNotificationFor('whatsapp')) {
            $channels[] = 'whatsapp';
        }
        
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title)
            ->greeting("Hello {$notifiable->name},")
            ->line($this->message)
            ->line("This action was taken by {$this->chairperson->name}.")
            ->action($this->actionText, $this->actionUrl)
            ->line('Thank you for your cooperation.');
    }

    public function toWhatsApp($notifiable): string
    {
        return sprintf(
            "📢 %s\n\nDear %s,\n\n%s\n\nAction by: %s\n\nClick here to view: %s",
            $this->title,
            $notifiable->name,
            $this->message,
            $this->chairperson->name,
            $this->actionUrl
        );
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'action_text' => $this->actionText,
            'action_url' => $this->actionUrl,
            'chairperson_id' => $this->chairperson->id,
            'chairperson_name' => $this->chairperson->name
        ];
    }
}
