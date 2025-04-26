<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Payment;

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Successful')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your payment of TZS ' . number_format($this->payment->amount) . ' has been received.')
            ->line('Transaction ID: ' . $this->payment->transaction_id)
            ->action('View Receipt', route('member.payments.show', $this->payment))
            ->line('Thank you for your contribution!');
    }

    public function toArray($notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount,
            'transaction_id' => $this->payment->transaction_id,
        ];
    }
}
