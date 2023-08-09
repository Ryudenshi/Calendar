<?php

namespace App\Console;

use App\Mail\EventEndMail;
use App\Mail\EventStartMail;
use App\Mail\ReminderStartMail;
use App\Models\Event;
use App\Models\Reminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $now = now();
            $events = Event::where('start_datetime', '>', $now)
                ->where('start_datetime', '<=', $now->copy()->addDay())
                ->get();

            foreach ($events as $event) {
                Mail::to($event->user->email)->send(new EventStartMail($event));
            }
        })->dailyAt('09:00');

        $schedule->call(function () {
            $now = now();
            $events = Event::where('end_datetime', '>', $now)
                ->where('end_datetime', '<=', $now->copy()->addDay())
                ->get();

            foreach ($events as $event) {
                Mail::to($event->user->email)->send(new EventEndMail($event));
            }
        })->dailyAt('09:00');

        $schedule->call(function () {
            $now = now();
            $reminders = Reminder::where('datetime', '>', $now)
                ->where('datetime', '<=', $now->copy()->addDay())
                ->get();

            foreach ($reminders as $reminder) {
                Mail::to($reminder->user->email)->send(new ReminderStartMail($reminder));
            }
        })->dailyAt('09:00');

        $schedule->command('send:event-reminders')->dailyAt('09:00');
    }



    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
