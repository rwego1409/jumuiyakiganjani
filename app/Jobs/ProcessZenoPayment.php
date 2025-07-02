<?php
namespace App\Jobs;

use App\Models\Contribution;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ProcessZenoPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public array $payload
    ) {}

    public function handle()
    {
        Log::info('Processing ZenoPay payment', $this->payload);

        // Find member by phone (preferred) or email/name if needed
        $member = Member::where('phone', $this->payload['buyer_phone'] ?? null)->first();
        if (!$member && isset($this->payload['buyer_email'])) {
            $member = Member::whereHas('user', function($q) {
                $q->where('email', $this->payload['buyer_email']);
            })->first();
        }
        if (!$member && isset($this->payload['buyer_name'])) {
            $member = Member::whereHas('user', function($q) {
                $q->where('name', $this->payload['buyer_name']);
            })->first();
        }
        if (!$member) {
            Log::warning('No member found for ZenoPay payment', $this->payload);
            return;
        }

        // Create or update contribution
        $contribution = Contribution::firstOrNew([
            'payment_reference' => $this->payload['reference'] ?? $this->payload['order_id'] ?? null
        ]);
        $contribution->member_id = $member->id;
        $contribution->jumuiya_id = $member->jumuiya_id;
        $contribution->amount = $this->payload['amount'] ?? 0;
        $contribution->contribution_date = Carbon::now();
        $contribution->payment_method = 'mobile';
        $contribution->purpose = $this->payload['purpose'] ?? 'ZenoPay';
        $contribution->status = ($this->payload['payment_status'] ?? null) === 'COMPLETED' ? 'paid' : 'pending';
        $contribution->payment_reference = $this->payload['reference'] ?? $this->payload['order_id'] ?? null;
        $contribution->save();
    }
}
