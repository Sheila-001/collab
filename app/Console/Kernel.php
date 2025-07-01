<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\AddTestAdminEvent::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * These schedules are run in the console.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Update campaign statuses daily at midnight
        $schedule->command('campaigns:update-status')->daily();

        // Update urgent campaign statuses daily at midnight
        $schedule->command('urgent-campaigns:update-status')->daily();

        // Update urgent campaign totals daily at 1 AM
        $schedule->command('urgent-campaigns:update-totals')->dailyAt('01:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 