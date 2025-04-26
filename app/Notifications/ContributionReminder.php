<?php

namespace App\Notifications;

use App\Models\Contribution;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContributionReminder extends Notification
{
    use Queueable;

    protected $contribution;

    public function __construct(Contribution $contribution)
    {
        $this->contribution = $contribution;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Contribution Reminder')
            ->line('You have a pending contribution for ' . $this->contribution->course->name)
            ->line('Amount: TZS ' . number_format($this->contribution->amount))
            ->action('View Contribution', route('member.contributions.show', $this->contribution->id))
            ->line('Thank you for your support!');
    }

    public function toArray($notifiable)
    {
        return [
            'contribution_id' => $this->contribution->id,
            'amount' => $this->contribution->amount,
            'course_name' => $this->contribution->course->name,
        ];
    }
}
