<?php

namespace App\Console;

use App\Console\Commands\EmailInactiveUsers;
use App\Console\Commands\DeleteInactiveUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
 
    protected $commands =[
        EmailInactiveUsers::class,
        DeleteInactiveUsers::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:inactive-users')->dailyAt('12:57');
        $schedule->command('delete:inactive-users')->dailyAt('12:20');
    }

    protected function scheduleTimezone()
    {
        return config('app.timezone');
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
