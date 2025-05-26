<?php

namespace App\Notifications;

use App\Models\Contribution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContributionCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public $contribution;

    public function __construct(Contribution $contribution)
    {
        $this->contribution = $contribution;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $paymentLink = route('member.payments.create', ['contribution' => $this->contribution->id]);
        
        return (new MailMessage)
            ->subject('New Contribution Request')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new contribution has been created for you.')
            ->line('Amount: TZS ' . number_format($this->contribution->amount))
            ->line('Purpose: ' . ($this->contribution->purpose ?? 'General Contribution'))
            ->line('Payment Method: ' . ucfirst($this->contribution->payment_method))
            ->action('Make Payment', $paymentLink)
            ->line('Thank you for your support!');
    }

    public function toArray($notifiable): array
    {
        return [
            'contribution_id' => $this->contribution->id,
            'amount' => $this->contribution->amount,
            'purpose' => $this->contribution->purpose ?? 'General Contribution',
            'payment_method' => $this->contribution->payment_method,
            'payment_link' => route('member.payments.create', ['contribution' => $this->contribution->id]),
        ];
    }
}
