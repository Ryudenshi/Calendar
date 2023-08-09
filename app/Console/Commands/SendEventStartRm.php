<?php

namespace App\Console\Commands;

use App\Mail\EventStartMail;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventStartRm extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send event reminders to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $tomorrow = $now->copy()->addDay();

        $events = Event::whereDate('start_datetime', $tomorrow)->get();

        foreach ($events as $event) {
            Mail::to($event->user->email)
                ->send(new EventStartMail($event));
        }
    }
}
