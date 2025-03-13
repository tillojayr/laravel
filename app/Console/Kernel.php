<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\UpdateProductQuantity::class,
        \App\Console\Commands\DeleteLowQuantityProducts::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('products:delete-low-quantity')->mondays()->at('00:00');
    }
}
