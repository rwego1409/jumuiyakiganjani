<?php

namespace App\Services;

use App\Models\{User, Notification};
use Illuminate\Support\Facades\Mail;
use App\Mail\{ContributionReminderMail, EventReminderMail, PaymentConfirmationMail};

class NotificationService
{
    public function create(User $user, string $type, string $message, array $data = [])
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function sendContributionReminder(User $user, $contribution)
    {
        // Create notification record
        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => 'contribution_reminder',
            'data' => [
                'contribution_id' => $contribution->id,
                'amount' => $contribution->amount,
                'due_date' => $contribution->due_date
            ],
            'read_at' => null
        ]);

        // Send email
        Mail::to($user->email)->queue(new ContributionReminderMail($contribution));

        return $notification;
    }

    public function sendEventReminder($user, $event)
    {
        $notification = $this->create($user, 'event_reminder', [
            'event_id' => $event->id,
            'title' => $event->title,
            'start_time' => $event->start_time,
            'location' => $event->location
        ]);

        Mail::to($user->email)->queue(new EventReminderMail($event));

        return $notification;
    }

    public function sendPaymentConfirmation($user, $payment)
    {
        $notification = $this->create($user, 'payment_confirmation', [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'transaction_id' => $payment->transaction_id
        ]);

        Mail::to($user->email)->queue(new PaymentConfirmationMail($payment));

        return $notification;
    }

    public function markAsRead($notificationId)
    {
        return Notification::where('id', $notificationId)
            ->update(['read_at' => now()]);
    }

    public function getUnreadCount($userId)
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    public function getUnreadNotifications($user, $limit = 5)
    {
        return $user->notifications()
            ->whereNull('read_at')
            ->latest()
            ->limit($limit)
            ->get();
    }
}