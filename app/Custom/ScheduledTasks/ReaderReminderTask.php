<?php

namespace App\Custom\ScheduledTasks;

use App\Custom\Utilities;
use App\Mail\ReaderReminderMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReaderReminderTask {

    public function __invoke()
    {
        $reminders = DB::table('check_outs')
        ->join('users', 'check_outs.user_id', '=', 'users.id')
        ->join('books', 'check_outs.book_id', '=', 'books.id')
        ->where('check_outs.check_out_status', '!=', 1)
        ->get();

        foreach ($reminders as $reminder) {
            $checkOutDate = $reminder->check_out_date;
            $expectedDate = $reminder->expected_date;
            $checkInDate = $reminder->check_in_date;
            $currentDate = date(Utilities::$DATE_FORMAT, time());

            if ($currentDate < $expectedDate && Utilities::confirmToSend($expectedDate, $currentDate)) {
                Mail::to($reminder->email)->send(new ReaderReminderMail($reminder));
            }
        }
    }
}