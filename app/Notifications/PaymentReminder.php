<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MemberCourseContribution $contribution
    ) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Reminder: ' . $this->contribution->course->name)
            ->line('Your payment of ' . number_format($this->contribution->amount) . ' TZS is due on ' . $this->contribution->due_date->format('M d, Y'))
            ->action('Make Payment', route('member.payments.create', $this->contribution))
            ->line('Thank you for your timely contribution!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Payment reminder for ' . $this->contribution->course->name,
            'contribution_id' => $this->contribution->id,
            'due_date' => $this->contribution->due_date,
            'amount' => $this->contribution->amount
        ];
    }
}