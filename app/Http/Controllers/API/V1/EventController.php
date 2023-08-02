<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

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
        $user = Auth::user(); // Get the authenticated user
        $eventData = $request->all();
        $eventData['user_id'] = $user->id; // Associate the event with the user

        $event = Event::create($eventData);
        return response()->json(['message' => 'Event created successfully', 'event' => new EventResource($event)]);
    }

    // Update event details
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Check if the authenticated user is the owner of the event
        if (Auth::user()->id !== $event->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $event->update($request->all());
        return response()->json(['message' => 'Event updated successfully', 'event' => new EventResource($event)]);
    }

    // Delete an event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Check if the authenticated user is the owner of the event
        if (Auth::user()->id !== $event->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
}
