<?php
namespace App\Events;

use App\Models\Contribution;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContributionPaid implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contribution;

    public function __construct(Contribution $contribution)
    {
        $this->contribution = $contribution;
    }

    public function broadcastOn()
    {
        return new Channel('contributions');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->contribution->id,
            'status' => $this->contribution->status,
            'amount' => $this->contribution->amount,
            'user_id' => $this->contribution->user_id,
            'updated_at' => $this->contribution->updated_at->toDateTimeString(),
        ];
    }
}
