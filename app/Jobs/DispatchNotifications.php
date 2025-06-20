<?php

namespace App\Jobs;

use App\Models\AdminNotification;
use App\Notifications\AdminCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DispatchNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public AdminNotification $notification)
    {
    }

    public function handle()
    {
        $users = $this->getRecipients($this->notification);
        
        foreach ($users as $user) {
    $user->notify(new AdminCreatedNotification($this->notification));
    usleep(300000); // sleep 0.3 seconds between sends (~3 per second)
}

    }

    protected function getRecipients(AdminNotification $notification)
    {
        $query = \App\Models\User::where('id', '!=', $notification->created_by);
        
        if (in_array('all', $notification->recipients)) {
            // Include chairpersons and members in the recipients
            $query->whereIn('role', ['chairperson', 'member']);
        } else {
            $query->whereIn('id', $notification->user_ids);
        }
        
        return $query->get();
    }
}