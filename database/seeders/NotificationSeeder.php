<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Notifications\DummyNotification;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'admin')->first();
        $member = User::where('role', 'member')->first();

        // Admin notifications
        $admin->notify(new DummyNotification('New member registration', 'info'));
        $admin->notify(new DummyNotification('Urgent: System update required', 'warning'));
        
        // Member notifications
        $member->notify(new DummyNotification('Your contribution was received', 'success'));
        $member->notify(new DummyNotification('Upcoming event: Community meeting', 'info'));
        $member->notify(new DummyNotification('Payment reminder', 'warning'));
    }
}
