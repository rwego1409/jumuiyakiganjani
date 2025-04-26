<?php

namespace App\Console\Commands;

use App\Models\Jumuiya;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SendPaymentReminders extends Command
{
    protected $signature = 'reminders:send';

    public function handle()
    {
        $contributions = MemberCourseContribution::with(['member.user', 'course'])
            ->where('is_paid', false)
            ->whereDate('due_date', '<=', now()->addDays(3))
            ->whereDate('due_date', '>=', now())
            ->get();

        foreach ($contributions as $contribution) {
            if ($contribution->member->receive_payment_reminders) {
                $contribution->member->user->notify(new PaymentReminder($contribution));
            }
        }

        $this->info('Sent ' . $contributions->count() . ' payment reminders');
    }
}