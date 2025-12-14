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
        // TASK 1: Calculate THIS Month
        // Run: Every night at 01:00 AM
        // Purpose: So the dashboard is always fresh for the next morning.
        $schedule->command('rankings:recompute', [
            '--year' => now()->year,
            '--month' => now()->month,
        ])->dailyAt('01:00');

        // TASK 2: Finalize LAST Month
        // Run: ONLY on the 1st day of the month at 01:30 AM
        // Purpose: To "lock in" the final scores for the month that just finished.
        $schedule->command('rankings:recompute', [
            '--year' => now()->subMonth()->year,
            '--month' => now()->subMonth()->month,
        ])->monthlyOn(1, '01:30');
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
