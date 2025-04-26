<?php

// app/Events/PaymentProcessed.php
namespace App\Events;

use App\Models\Contribution;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentProcessed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contribution;

    public function __construct(Contribution $contribution)
    {
        $this->contribution = $contribution;
    }

    public function broadcastOn()
    {
        return new Channel('contributions.'.$this->contribution->member_id);
    }

    public function broadcastWith()
    {
        return [
            'course_id' => $this->contribution->course_id,
            'new_balance' => $this->contribution->member->courseContributions()
                ->where('course_id', $this->contribution->course_id)
                ->first()->pivot->paid_amount,
            'target_amount' => $this->contribution->course->target_amount
        ];
    }
}