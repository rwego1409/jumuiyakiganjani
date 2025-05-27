<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChairpersonMembershipNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Member $member,
        protected string $action, // 'approved', 'rejected', 'updated', etc.
        protected ?string $reason = null
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
        $message = (new MailMessage)
            ->subject("Membership {$this->action}")
            ->greeting("Hello {$notifiable->name},");

        switch ($this->action) {
            case 'approved':
                $message->line("Your membership application has been approved.")
                    ->line("Welcome to {$this->member->jumuiya->name}!");
                break;
            case 'rejected':
                $message->line("Your membership application has been rejected.")
                    ->line("Reason: {$this->reason}");
                break;
            case 'updated':
                $message->line("Your membership details have been updated.")
                    ->line("Please review the changes in your profile.");
                break;
        }

        return $message->action('View Details', route('member.profile'))
            ->line('Thank you for being part of our community.');
    }

    public function toWhatsApp($notifiable): string
    {
        $message = "Dear {$notifiable->name},\n\n";

        switch ($this->action) {
            case 'approved':
                $message .= "🎉 Congratulations! Your membership application has been approved.\n";
                $message .= "Welcome to {$this->member->jumuiya->name}!\n";
                break;
            case 'rejected':
                $message .= "❌ Your membership application has been rejected.\n";
                if ($this->reason) {
                    $message .= "Reason: {$this->reason}\n";
                }
                break;
            case 'updated':
                $message .= "ℹ️ Your membership details have been updated.\n";
                $message .= "Please review the changes in your profile.\n";
                break;
        }

        $message .= "\nVisit " . route('member.profile') . " to view details.";
        
        return $message;
    }

    public function toArray($notifiable): array
    {
        return [
            'member_id' => $this->member->id,
            'action' => $this->action,
            'reason' => $this->reason,
            'jumuiya' => $this->member->jumuiya->name,
        ];
    }
}
