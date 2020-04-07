<?php

namespace App\Console;

use App\Console\Commands\VerifyRegisters;
use App\Console\Commands\VerifyReturns;
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
        VerifyRegisters::class,
        VerifyReturns::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sponsored:register')->timezone('America/Lima')->weeklyOn(2, '23:00');
        $schedule->command('sponsored:register')->timezone('America/Lima')->weeklyOn(5, '23:00');

        $schedule->command('sponsored:return')->timezone('America/Lima')->weeklyOn(3, '23:00');
        $schedule->command('sponsored:return')->timezone('America/Lima')->weeklyOn(6, '23:00');
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
