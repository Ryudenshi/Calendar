<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Get all events for a specific user
    public function index($userId)
    {
        $events = Event::where('user_id', $userId)->get();
        return EventResource::collection($events);
    }

    // Get event details by ID
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return new EventResource($event);
    }

    // Create a new event
    public function store(Request $request)
    {
        $event = Event::create($request->all());
        return new EventResource($event);
    }

    // Update event details
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return new EventResource($event);
    }

    // Delete an event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
}
