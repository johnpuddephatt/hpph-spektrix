<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule
            ->command('media-library:delete-old-temporary-uploads')
            ->daily();

        $schedule->command('fetch:all')->hourly();
        // ~50s for a few hundred instances, one Spektrix call each, so guard
        // against a slow run overlapping the next.
        $schedule->command('cache:availability')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('cache:programme')->everyFiveMinutes();

        // Separate from cache:programme so a slow or failing page warm cannot
        // delay the query warming the site depends on.
        $schedule->command('cache:pages')->everyFiveMinutes()->withoutOverlapping();
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
