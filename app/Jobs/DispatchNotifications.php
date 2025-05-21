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
        if (in_array('all', $notification->recipients)) {
            return \App\Models\User::where('id', '!=', $notification->created_by)->get();
        }

        return \App\Models\User::whereIn('id', $notification->user_ids)->get();
    }
}