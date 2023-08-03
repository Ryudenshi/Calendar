<?php

// app/Http/Controllers/EventController.php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
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

        return response()->json($event, 201);
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
