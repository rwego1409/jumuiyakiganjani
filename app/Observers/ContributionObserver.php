<?php

namespace App\Observers;

use App\Models\Contribution;
use App\Notifications\ContributionCreated;
use Illuminate\Support\Facades\Notification;

class ContributionObserver
{
    public function created(Contribution $contribution)
    {
        // Skip notifications during seeding
        if (app()->environment('testing') || defined('SEEDING')) {
            return;
        }

        // Schedule reminder 3 days before due date if due date is set
        if ($contribution->due_date) {
            $contribution->scheduleReminderBeforeDueDate(3);
        }

        // Send notification to member about new contribution
        if ($contribution->member && $contribution->member->user) {
            Notification::send($contribution->member->user, new ContributionCreated($contribution));
        }
    }

    public function updated(Contribution $contribution)
    {
        if ($contribution->isDirty('due_date') && !$contribution->isPaid()) {
            // If due date changed and not paid, reschedule reminder
            $contribution->reminders()->pending()->delete();
            $contribution->scheduleReminderBeforeDueDate(3);
        }

        if ($contribution->isPaid()) {
            // If contribution is now paid, cancel any pending reminders
            $contribution->reminders()->pending()->delete();
        }
    }
}
