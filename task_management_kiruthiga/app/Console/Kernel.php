<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
 // In app/Console/Kernel.php
protected $commands = [
    \App\Console\Commands\UpdateOverdueDays::class,
];

protected function schedule(Schedule $schedule)
{
    $schedule->command('tasks:update-overdue')->daily(); // Run daily
}



    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
