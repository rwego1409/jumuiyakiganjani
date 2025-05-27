<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Process WhatsApp reminders every 5 minutes
        $schedule->command('whatsapp:process-reminders')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        // Monitor WhatsApp message delivery status every 5 minutes
        $schedule->command('whatsapp:monitor-delivery')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        // Clean up old reminders weekly
        $schedule->command('whatsapp:cleanup-reminders')
            ->weekly()
            ->sundays()
            ->at('00:00')
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
