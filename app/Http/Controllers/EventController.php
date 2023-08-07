<?php

namespace App\Http\Controllers;

use App\Events\EventStore;
use App\Jobs\EventReminderJob;
use App\Jobs\TelegramNotificationJob;
use App\Mail\EventReminderMail;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', Auth::user()->id)->get();

        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_datetime,
                'end' => $event->end_datetime,
                'color' => $event->color,
                'completed' => $event->completed,
            ];
        }

        return response()->json($formattedEvents);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'required|string|max:20',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
        ]);

        $event = new Event($request->all());
        $event->user_id = Auth::user()->id;
        $event->save();

        $event->start_datetime = Carbon::parse($event->start_datetime)->format('Y-m-d\TH:i:s');
        $event->end_datetime = Carbon::parse($event->end_datetime)->format('Y-m-d\TH:i:s');

        //event(new EventStore($event));
        //dispatch(new TelegramNotificationJob(Auth::user(), $event));

        return response()->json(['event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        if (Auth::user()->id !== $event->user_id) {
            return response()->json(['message' => 'Access denied.'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'required|string|max:20',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'completed' => 'required|boolean',
        ]);

        $event->update($request->all());

        return response()->json($event, 200);
    }

    public function destroy(Event $event)
    {
        if (Auth::user()->id !== $event->user_id) {
            return response()->json(['message' => 'Access denied.'], 403);
        }

        $event->delete();

        return response()->json(null, 204);
    }
}
