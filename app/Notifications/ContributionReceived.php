<?php

namespace App\Notifications;
use App\Models\Contribution;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ContributionReceived extends Notification
{
    protected $contribution;

    public function __construct($contribution)
    {
        $this->contribution = $contribution;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'amount' => $this->contribution->amount,
            'date' => $this->contribution->contribution_date,
            'jumuiya' => $this->contribution->jumuiya->name,
        ];
    }
}
