<?php

namespace App\Console;

use App\Custom\Utilities;
use App\Mail\ReaderReminderMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;
use App\Custom\ScheduledTasks\ReaderReminderTask;
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
        // $schedule->call(new ReaderReminderTask)->everyTenMinutes();

        $schedule->call(function () {

            $reminders = DB::table('check_outs')
            ->join('users', 'check_outs.user_id', '=', 'users.id')
            ->join('books', 'check_outs.book_id', '=', 'books.id')
            ->where('check_outs.check_out_status', '!=', 1)
            ->get();

            if ($reminders != null) {

                foreach ($reminders as $reminder) {
                    $checkOutDate = $reminder->check_out_date;
                    $expectedDate = $reminder->expected_date;
                    $checkInDate = $reminder->check_in_date;
                    $currentDate = date(Utilities::DATE_FORMAT, time());

                    if ($currentDate < $expectedDate && Utilities::confirmToSend($expectedDate, $currentDate)) {
                        Mail::to($reminder->email)->send(new ReaderReminderMail($reminder));
                    }
                }
            }

        })->everyTenMinutes();
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
