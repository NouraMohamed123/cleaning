<?php

namespace App\Console;


use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //     $currentTime = Carbon::now();
        //     $bookings = Booking::all();
        //     foreach ($bookings as $booking) {
        //         $timeDifference = $currentTime->diffInHours($booking->booking_time);
        //         $availability  = $timeDifference >= ($booking->service->duration ?? 2) ? 1 : 0;
        //         $booking->available = $availability;
        //         $booking->save();
        //     }
        // })->everyMinute();

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
