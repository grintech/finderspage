<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Blogs;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
      
        Commands\NotifyListingsExpiring::class,
       
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('message:cron')
            ->timezone('Europe/London')
            ->everyFifteenMinutes();

        $schedule->command('VideoPublish:cron')
            ->daily();

        $schedule->command('cron:video')->everyMinute();

        $schedule->command('posts:update-expired')->everyFifteenMinutes(); // Adjust the schedule frequency as needed

        $schedule->command('removepost')->everyFifteenMinutes(); // Adjust the schedule frequency as needed

        $schedule->command('posts:update-status')->daily(); // Runs daily

        $schedule->command('notify:listings-expiring')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
